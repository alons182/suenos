<?php namespace Suenos\Users;


interface UserRepository {

    public function findByUsername($id);
    public function store($data);


} 