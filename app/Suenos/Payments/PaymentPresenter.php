<?php namespace Suenos\Payments;

use Laracasts\Presenter\Presenter;

class PaymentPresenter extends Presenter {

    public function paymentType()
    {
        return \Lang::get('utils.payments_type.'. $this->payment_type);
    }

}
