<?php namespace Suenos\Forms;


use Laracasts\Validation\FormValidator;

class ProfileForm extends FormValidator{


    protected $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'ide' => 'required',
        'code_zip' => 'required',
        'address' => 'required',
        'telephone' => 'required',
        'country' => 'required',
        'estate' => 'required',
        'city' => 'required',
        'bank' => 'required',
        'type_account' => 'required',
        'number_account' => 'required',
        'nit' => 'required',
        'skype' => 'required'

    ];

} 