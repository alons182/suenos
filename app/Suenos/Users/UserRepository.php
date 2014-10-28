<?php namespace Suenos\Users;


interface UserRepository {

    public function findByUsername($id);
    public function store($data);
    public function getLasts();
    public function reportPaidsByDay($date = null);
    public function reportPaidsByMonth($month, $year);



} 