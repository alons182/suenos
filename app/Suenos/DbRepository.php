<?php namespace Suenos;

class DbRepository {

    protected $model;

    function __construct($model)
    {
        $this->model = $model;
    }

    public function store($data)
    {
        return $this->model->create($data);
    }

    public function paginate($limit)
    {
        return $this->model->paginate($limit);
    }


} 