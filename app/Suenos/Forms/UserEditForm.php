<?php namespace Suenos\Forms;


use Laracasts\Validation\FormValidator;

class UserEditForm extends FormValidator {

    protected $rules = [
        'username' => 'required',
        'email' => 'required|email',
        'password' => 'confirmed',


    ];

} 