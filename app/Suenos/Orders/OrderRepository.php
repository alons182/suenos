<?php namespace Suenos\Orders;

interface OrderRepository {
    public function store($data);
    public function findAll($data);
}