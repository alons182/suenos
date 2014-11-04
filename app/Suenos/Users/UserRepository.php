<?php namespace Suenos\Users;


interface UserRepository {

    public function findByUsername($id);
    public function store($data);
    public function getLasts();
    public function reportPaymentsByDay($date = null);
    public function reportPaymentsByMonth($month, $year);



} 