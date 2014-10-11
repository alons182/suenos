<?php namespace Suenos\Orders;

use Laracasts\Presenter\PresentableTrait;

class Order extends \Eloquent {

    use PresentableTrait;
    protected $table = 'orders';

    /**
     * Path to presenter for a profile
     * @var string
     */
    //protected $presenter = 'Suenos\Orders\OrderPresenter';

    protected $fillable = [
        'user_id','description','total'
    ];

    public function details()
    {
        return $this->hasMany('Suenos\Orders\Detail');
    }


} 