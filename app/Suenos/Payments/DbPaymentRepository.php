<?php namespace Suenos\Payments;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Suenos\DbRepository;
use Suenos\Mailers\PaymentMailer;
use Suenos\Users\User;

class DbPaymentRepository extends DbRepository implements PaymentRepository {

    /**
     * @var Payment
     */
    protected $model;
    /**
     * @var PaymentMailer
     */
    private $mailer;

    function __construct(Payment $model, PaymentMailer $mailer)
    {
        $this->model = $model;
        $this->limit = 20;
        $this->membership_cost = 20000;
        $this->mailer = $mailer;
    }


    /**
     * Save a payment
     * @param $data
     * @return mixed
     */
    public function store($data)
    {
        $data = $this->prepareData($data);

        if ($this->existsAutomaticPaymentOfMonth()) return false;

        return $this->model->create($data);

    }

    /**
     * Get all payments of users of one red's user
     * @param null $data
     * @return Collection
     */
    public function getPaymentsOfYourRed($data = null)
    {


        // payments for the current user logged
        $paymentsOfUser = $this->model->where(function ($query) use ($data)
        {
            $query->where('user_id','=', Auth::user()->id)
                ->where(\DB::raw('MONTH(created_at)'), '=', $data['month'])
                ->where(\DB::raw('YEAR(created_at)'), '=', Carbon::now()->year);
        });
        $paymentOfUser = $paymentsOfUser->sum(\DB::raw('amount'));
        $paymentsOfUser = $paymentsOfUser->paginate($this->limit);

        // payments for the users from the current user logged
        $usersOfRed = Auth::user()->children()->get()->lists('id');
        if ($usersOfRed)
        {
            $paymentsOfRed = $this->model->with('users', 'users.profiles')->where(function ($query) use ($usersOfRed, $data)
            {
                $query->whereIn('user_id', $usersOfRed)
                    ->where(\DB::raw('MONTH(created_at)'), '=', $data['month'])
                    ->where(\DB::raw('YEAR(created_at)'), '=', Carbon::now()->year);
            });

            $gain = $paymentsOfRed->sum(\DB::raw('gain'));



            $membership_cost = ($paymentsOfRed->count()) ? $paymentsOfRed->first()->membership_cost : $this->membership_cost;


            $payments = $paymentsOfRed->paginate($this->limit);


        } else
        {
            $payments = [];
            $gain = 0;
            $membership_cost = $this->membership_cost;

        }

        $data = array(
            'gain_bruta' => $gain,
            'gain_neta'  => $gain  - $membership_cost,
            'paymentOfUser' => ($paymentOfUser > 20000 ? 20000 : $paymentOfUser ) ,
            'payments'   => $payments,
            'paymentsOfUser'   => $paymentsOfUser
        );

        return new Collection($data);

    }

    /**
     * Generate a payment for any user for month
     */
    public function membershipFee()
    {

        $users = User::all();
        $users_payments = 0;
        $amount = 0;
        $gain = 0;
        foreach ($users as $user)
        {
            $usersOfRed =$user->children()->get()->lists('id');
            $countUsersOfRed = $user->children()->count();

            if($countUsersOfRed)
            {
                if (!$this->existsPaymentOfMonth($user->id))
                {

                    if($countUsersOfRed == 1 )
                    {

                        $amount = $this->userOfRedPayments($usersOfRed);
                        $gain = $amount;

                    }else if($usersOfRed > 1 )
                    {
                        $amount = ($this->userOfRedPayments($usersOfRed) > 20000) ? 20000 : $this->userOfRedPayments($usersOfRed);
                        $gain = ($amount < 20000) ? 0 : $amount - 5000;


                    }

                    if($amount > 0)
                    {
                        $this->model->create([
                            'user_id'         => $user->id,
                            'membership_cost' => $this->membership_cost,
                            'payment_type'    => "MA",
                            'amount'          => $amount,
                            'gain'            => $gain,
                            'bank'            => 'Pago de membresía Automático',
                            'transfer_number' => 'Pago de membresía Automático',
                            'transfer_date'   => Carbon::now()
                        ]);
                    }

                    $users_payments++;

                    //$this->mailer->sendPaymentsMembershipMessageTo($user);
                }
            }



        }

        $this->mailer->sendReportMembershipMessageTo($users->count(), $users_payments);


    }
    private function userOfRedPayments($usersOfRed)
    {
        $paymentsOfRed = $this->model->where(function ($query) use ($usersOfRed)
        {
            $query->whereIn('user_id', $usersOfRed)
                ->where(\DB::raw('MONTH(created_at)'), '=', Carbon::now()->subMonth()->month)
                ->where(\DB::raw('YEAR(created_at)'), '=', (Carbon::now()->month == 1) ? Carbon::now()->subyear()->year : Carbon::now()->year);
        });

        //if($usersOfRed[0]==15)
       //     dd($paymentsOfRed->get()->toArray());
        $amount = $paymentsOfRed->sum(\DB::raw('gain'));

        return $amount;
    }

    /**
     * @param $data
     * @return array
     */
    private function prepareData($data)
    {
        $data = array_add($data, 'user_id', Auth::user()->id);
        $data = array_add($data, 'membership_cost', $this->membership_cost);
        $data = array_add($data, 'amount', ($data['payment_type'] == "M") ? $this->membership_cost : 5000);
        $data = array_add($data, 'gain', ($data['payment_type'] == "M") ? ($this->membership_cost - 5000) : 0);

        return $data;
    }

    /**
     * Verify the payments of month for not repeat one payment
     * @param null $user_id
     * @return mixed
     */
    public function existsPaymentOfMonth($user_id = null)
    {
        $payment = $this->model->where(function ($query) use ($user_id)
        {
            $query->where('user_id', '=', ($user_id)? $user_id : Auth::user()->id)
                ->where(\DB::raw('MONTH(created_at)'), '=', Carbon::now()->month)
                ->where(\DB::raw('YEAR(created_at)'), '=', Carbon::now()->year)
                ->where(function ($query)
                {
                    $query->where('payment_type', '=', 'M')
                        ->orWhere('payment_type', '=', 'A');
                });
        })->first();

        return $payment;
    }

    /**
     * Verify the payments of month for not repeat one payment
     * @param null $user_id
     * @return mixed
     */
    public function existsAutomaticPaymentOfMonth($user_id = null)
    {
        $countUsersOfRed = uth::user()->children()->count();
        $payment = false;

        if($countUsersOfRed > 1)
        {
            $payment = $this->model->where(function ($query) use ($user_id)
            {
                $query->where('user_id', '=', ($user_id)? $user_id : Auth::user()->id)
                    ->where(\DB::raw('MONTH(created_at)'), '=', Carbon::now()->month)
                    ->where(\DB::raw('YEAR(created_at)'), '=', Carbon::now()->year)
                    ->where(function ($query)
                    {
                        $query->where('payment_type', '=', 'MA');

                    });
            })->first();
        }


        return $payment;
    }


}