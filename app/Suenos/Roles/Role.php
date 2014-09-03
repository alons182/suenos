<?php namespace Suenos\Roles;


class Role extends \Eloquent {


    protected $table = 'roles';

    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany('Suenos\Users\User');
    }
}