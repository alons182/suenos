<?php namespace Suenos\Products;


interface ProductRepository {

    public function findById($id);
    public function store($data);
    public function getLasts();
    public function getAll($search);


} 