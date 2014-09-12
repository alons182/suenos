<?php namespace Suenos\Payments;


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
        $this->limit = 10;
    }


    public function store($data)
    {
        $data = $this->prepareData($data);

        return $this->model->create($data);
    }

    public function getPaymentsOfYourRed()
    {
        $usersOfRed = Auth::user()->children()->get()->lists('id');

        if($usersOfRed)
        {
            $payments = $this->model->with('users','users.profiles')->whereIn('user_id',$usersOfRed)->paginate($this->limit);
            $gain = $this->model->whereIn('user_id',$usersOfRed)->sum('gain');

        }else{
            $payments = [];
            $gain = 0;
        }

        $data = array(
            'gain' => $gain,
            'payments' => $payments
            );

        return new Collection($data);
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