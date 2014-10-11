<?php namespace Suenos\Forms;


use Laracasts\Validation\FormValidator;

class ProfileForm extends FormValidator{


    protected $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'ide' => 'required',
        'address' => 'required',
        'telephone' => 'required',
        'estate' => 'required',
        'city' => 'required',
        'bank' => 'required',
        'number_account' => 'required',


    ];

} 