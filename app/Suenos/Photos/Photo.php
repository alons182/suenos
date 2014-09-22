<?php namespace Suenos\Photos;

class Photo extends \Eloquent {

    protected $table = 'photos';

    protected $fillable = [

        'product_id', 'url', 'url_thumb'

    ];


    public function products()
    {
        return $this->belongsTo('Suenos\Products\Product');
    }
}