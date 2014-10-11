<?php namespace Suenos\Orders;

use Illuminate\Support\Facades\Auth;
use Suenos\DbRepository;

class DbOrderRepository extends DbRepository implements OrderRepository {

    /**
     * @var Payment
     */
    protected $model;

    function __construct(Order $model)
    {
        $this->model = $model;
        $this->limit = 20;

    }


    public function store($data)
    {
        $data = $this->prepareData($data);
        //dd(substr($data['item_options_1'], 9));
        $order = $this->model->create($data);
        $this->sync_orderDetail($order, $data);

        return $order;

    }

    public function sync_orderDetail($order, $data)
    {
        for ($i = 1; $i <= $data['itemCount']; $i ++)
        {
            $detail = new Detail;
            $detail->product_id = substr($data['item_options_'.$i], 9);
            $detail->quantity = $data[ 'item_quantity_' . $i ];
            $order->details()->save($detail);
        }


    }

    public function findAll($data)
    {
        $orders = Auth::user()->orders()->paginate($this->limit);
        return $orders;
    }

    public function findById($id)
    {
        return $this->model->with('details')->findOrFail($id);
    }


    /**
     * @param $data
     * @return array
     */
    private function prepareData($data)
    {
        $data = array_add($data, 'user_id', Auth::user()->id);
        $description = "";
        $total = 0;
        for ($i = 1; $i <= $data['itemCount']; $i ++)
        {
            $description .= $data[ 'item_name_' . $i ].', ';
            $total += ($data[ 'item_price_' . $i ] * $data[ 'item_quantity_' . $i ]);
        }
        $data = array_add($data, 'description', $description);
        $data = array_add($data, 'total', $total);

        return $data;
    }


}