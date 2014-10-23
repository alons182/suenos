<?php namespace Suenos\Payments;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Suenos\DbRepository;
use Suenos\Users\User;

class DbPaymentRepository extends DbRepository implements PaymentRepository {

    /**
     * @var Payment
     */
    protected $model;

    function __construct(Payment $model)
    {
        $this->model = $model;
        $this->limit = 20;
        $this->membership_cost = 20000;
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

        if ($usersOfRed)
        {
            $payments = $this->model->with('users', 'users.profiles')->where(function ($query) use ($usersOfRed, $data)
            {
                $query->whereIn('user_id', $usersOfRed)
                    ->where(\DB::raw('MONTH(created_at)'), '=', $data['month'])
                    ->where(\DB::raw('YEAR(created_at)'), '=', Carbon::now()->year);
            });

            $gain = $payments->sum(\DB::raw('gain'));
            $membership_cost = ($payments->count()) ? $payments->first()->membership_cost : $this->membership_cost;


            $payments = $payments->paginate($this->limit);

        } else
        {
            $payments = [];
            $gain = 0;
            $membership_cost = $this->membership_cost;

        }

        $data = array(
            'gain_bruta' => $gain,
            'gain_neta'  => $gain - $membership_cost,
            'payments'   => $payments
        );

        return new Collection($data);

    }

    /**
     * Generate a paid for any user for month
     */
    public function membershipFee()
    {
        $users = User::all();

        foreach ($users as $user)
        {
            if (!$this->existsPaymentOfMonth($user->id))
            {
                $this->model->create([
                    'user_id'         => $user->id,
                    'membership_cost' => $this->membership_cost,
                    'payment_type'    => "M",
                    'amount'          => $this->membership_cost,
                    'gain'            => ($this->membership_cost - 5000),
                    'bank'            => 'Cobro de membresía',
                    'transfer_number' => 'Cobro de membresía',
                    'transfer_date'   => Carbon::now()
                ]);
            }

        }


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
                ->where(\DB::raw('YEAR(created_at)'), '=', Carbon::now()->year);
        })->first();

        return $payment;
    }


}