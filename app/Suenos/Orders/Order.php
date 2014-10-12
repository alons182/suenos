<?php namespace Suenos\Orders;

use Laracasts\Presenter\PresentableTrait;

class Order extends \Eloquent {

    use PresentableTrait;
    protected $table = 'orders';

    /**
     * Path to presenter for a profile
     * @var string
     */
    protected $presenter = 'Suenos\Orders\OrderPresenter';

    protected $fillable = [
        'user_id','description','total','status'
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search)
        {
            $query->where('total', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        });
    }

    public function details()
    {
        return $this->hasMany('Suenos\Orders\Detail');
    }
    public function users()
    {
        return $this->belongsTo('Suenos\Users\User','user_id');
    }



} 