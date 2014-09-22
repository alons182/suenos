<?php namespace Suenos\Forms;

use Laracasts\Validation\FormValidator;

class ProductForm extends FormValidator{


    protected $rules = [
        'name' => 'required',
        'description' => 'required',
        'price' => 'required',
        'categories' => 'required'

    ];

} 