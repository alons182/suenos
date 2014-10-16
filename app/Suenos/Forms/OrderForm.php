<?php namespace Suenos\Forms;


use Laracasts\Validation\FormValidator;

class OrderForm extends FormValidator{


    protected $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'ide' => 'required',
        'address' => 'required',
        'telephone' => 'required',
        'email' => 'required|email',
        'transfer_number' => 'required',
        'transfer_date' => 'required'


    ];

} 