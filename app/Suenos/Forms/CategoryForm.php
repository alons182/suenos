<?php namespace Suenos\Forms;

use Laracasts\Validation\FormValidator;

class CategoryForm extends FormValidator{


    protected $rules = [
        'name' => 'required'

    ];

} 