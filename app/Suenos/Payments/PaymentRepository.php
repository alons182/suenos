<?php namespace Suenos\Payments;


interface PaymentRepository {
    public function store($data);
    public function membershipFee();
} 