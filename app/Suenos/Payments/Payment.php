<?php namespace Suenos\Payments;

use Laracasts\Presenter\PresentableTrait;

class Payment extends \Eloquent {

    use PresentableTrait;
    protected $table = 'payments';

    /**
     * Path to presenter for a profile
     * @var string
     */
    protected $presenter = 'Suenos\Payments\PaymentPresenter';

    protected $fillable = [
        'user_id','bank','transfer_number','transfer_date','amount','gain','payment_type','membership_cost'
    ];

    public function setAmountAttribute($amount)
    {
        $this->attributes['amount'] = (number($amount) == "") ? 0 : number($amount);
    }
    public function setGainAttribute($gain)
    {
        $this->attributes['gain'] = (number($gain) == "") ? 0 : number($gain);
    }

    public function users()
    {
        return $this->belongsTo('Suenos\Users\User','user_id');
    }


} 