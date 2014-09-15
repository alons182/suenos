<?php namespace Suenos\Payments;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Suenos\DbRepository;

class DbPaymentRepository extends DbRepository implements PaymentRepository{

    /**
     * @var Payment
     */
    protected  $model;

    function __construct(Payment $model)
    {
        $this->model = $model;
        $this->limit = 2;
    }


    public function store($data)
    {
        $data = $this->prepareData($data);

        return $this->model->create($data);
    }

    public function getPaymentsOfYourRed($data = null)
    {

        $usersOfRed = Auth::user()->children()->get()->lists('id');

        if($usersOfRed)
        {
            $payments = $this->model->with('users','users.profiles')->where(function($query) use ($usersOfRed,$data)
                {
                    $query->whereIn('user_id', $usersOfRed)
                          ->where(\DB::raw('MONTH(created_at)'), '=', $data['month'] );
                })->paginate($this->limit);

            $gain = $this->model->where(function($query) use ($usersOfRed,$data)
            {
                $query->whereIn('user_id', $usersOfRed)
                    ->where(\DB::raw('MONTH(created_at)'), '=', $data['month'] );
            })->sum('gain');

        }else{
            $payments = [];
            $gain = 0;
        }

        $data = array(
            'gain_bruta' => $gain,
            'gain_neta' => $gain - 20000,
            'payments' => $payments
            );

        return new Collection($data);
    }
    public function membershipFee()
    {
        $users = User::all();

        foreach ($users as $user)
        {
            $this->model->create([
                'user_id' => $user->id,
                'amount' => 20000,
                'gain' => 15000,
                'bank' => 'Cobro de membresía',
                'transfer_number' => 'Cobro de membresía',
                'transfer_date' =>  $this->model->timestamp(),
            ]);
        }

       // return $gain_neta;
    }

    /**
     * @param $data
     * @return array
     */
    private function prepareData($data)
    {
        $data = array_add($data, 'user_id', Auth::user()->id);
        $data = array_add($data, 'amount', ($data['payment_type'] == "M") ? 20000 : 5000);
        $data = array_add($data, 'gain', ($data['payment_type'] == "M") ? (20000 - 5000) : 0);

        return $data;
    }


}