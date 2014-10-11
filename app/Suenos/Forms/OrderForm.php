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
        'card_number' => 'required',
        'exp_card' => 'required'


    ];

} 