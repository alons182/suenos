<?php namespace Suenos\Forms;


use Laracasts\Validation\FormValidator;

class RegistrationForm extends FormValidator {

    protected $rules = [
        'username' => 'required|unique:users',
        'email' => 'required|confirmed|email|unique:users',
        'password' => 'required|confirmed',
        'terms' => 'required'

    ];

} 