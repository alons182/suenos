<?php namespace Suenos\Forms;


use Laracasts\Validation\FormValidator;

class UserForm extends FormValidator {

    protected $rules = [
        'username' => 'required|unique:users',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed',


    ];

} 