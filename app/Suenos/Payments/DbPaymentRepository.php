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

        if ($this->existsPaymentOfMonth()) return false;

        return $this->model->create($data);

    }

    /**
     * Get all payments of users of one red's user
     * @param null $data
     * @return Collection
     */
    public function getPaymentsOfYourRed($data = null)
    {
        $usersOfRed = Auth::user()->children()->get()->lists('id');
        dd($usersOfRed);
        if ($usersOfRed)
        {
            $paymentsOfRed = $this->model->with('users', 'users.profiles')->where(function ($query) use ($usersOfRed, $data)
            {
                $query->whereIn('user_id', $usersOfRed)
                    ->where(\DB::raw('MONTH(created_at)'), '=', $data['month'])
                    ->where(\DB::raw('YEAR(created_at)'), '=', Carbon::now()->year);
            });

            $gain = $paymentsOfRed->sum(\DB::raw('gain'));

            $paymentsOfUser = $this->model->where(function ($query) use ($usersOfRed, $data)
            {
                $query->where('user_id','=', Auth::user()->id)
                    ->where(\DB::raw('MONTH(created_at)'), '=', $data['month'])
                    ->where(\DB::raw('YEAR(created_at)'), '=', Carbon::now()->year);
            });
            $paymentOfUser = $paymentsOfUser->sum(\DB::raw('amount'));
            //dd($paymentOfUser);


            $membership_cost = ($paymentsOfRed->count()) ? $paymentsOfRed->first()->membership_cost : $this->membership_cost;


            $payments = $paymentsOfRed->paginate($this->limit);
            $paymentsOfUser = $paymentsOfUser->paginate($this->limit);

        } else
        {
            $payments = [];
            $paymentsOfUser = [];
            $paymentOfUser = 0;
            $gain = 0;
            $membership_cost = $this->membership_cost;

        }

        $data = array(
            'gain_bruta' => $gain,
            'gain_neta'  => $gain  - $membership_cost,
            'paymentOfUser' => (($paymentOfUser + $gain) > 20000 ? 20000 : $paymentOfUser + $gain ) ,
            'payments'   => $payments,
            'paymentsOfUser'   => $paymentsOfUser
        );

        return new Collection($data);

    }

    /**
     * Generate a paid for any user for month
     */
    public function membershipFee()
    {

        $users = User::all();
        $users_payments = 0;
        foreach ($users as $user)
        {

            $usersOfRed = $user->children()->count();

            if($usersOfRed > 1)
            if (!$this->existsPaymentOfMonth($user->id))
            {

                $this->model->create([
                    'user_id'         => $user->id,
                    'membership_cost' => $this->membership_cost,
                    'payment_type'    => "MA",
                    'amount'          => $this->membership_cost,
                    'gain'            => ($this->membership_cost - 5000),
                    'bank'            => 'Pago de membresía Automatico',
                    'transfer_number' => 'Pago de membresía Automatico',
                    'transfer_date'   => Carbon::now()
                ]);

                $users_payments++;

                //$this->mailer->sendPaymentsMembershipMessageTo($user);
            }

        }

        $this->mailer->sendReportMembershipMessageTo($users->count(), $users_payments);


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
     * Verify the payments of month for not repeat one paid
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


}