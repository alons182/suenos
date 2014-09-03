<?php namespace Suenos\Payments;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
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
        'user_id','bank','transfer_number','transfer_date','amount','gain','payment_type'
    ];

    public function users()
    {
        return $this->belongsTo('Suenos\Users\User','user_id');
    }

} 