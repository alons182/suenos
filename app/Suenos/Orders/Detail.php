<?php
namespace Suenos\Orders;

class Detail extends \Eloquent {

    protected $table = 'orders_details';

    protected $fillable = [
        'order_id','product_id','quantity'
    ];

    public function orders()
    {
        return $this->belongsTo('Suenos\Orders\Order','order_id');
    }
    public function products()
    {
        return $this->belongsTo('Suenos\Products\Product','product_id');
    }
}