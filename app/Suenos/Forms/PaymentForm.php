<?php namespace Suenos\Forms;


use Laracasts\Validation\FormValidator;

class PaymentForm extends FormValidator{


    protected $rules = [
        'payment_type' => 'required',
        'bank' => 'required',
        'transfer_number' => 'required',
        'transfer_date' => 'required'

    ];

} 