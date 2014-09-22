<?php namespace Suenos\Products;


interface ProductRepository {

    public function findById($id);
    public function store($data);
    public function delete($id);
    public function getLasts();


} 