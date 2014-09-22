<?php namespace Suenos\Products;

use Laracasts\Presenter\Presenter;

class ProductPresenter extends Presenter {

    public function sizes()
    {
        return json_decode($this->sizes);
    }
    public function colors()
    {
        return json_decode($this->colors);
    }
    public function relateds()
    {
        return json_decode($this->relateds);
    }

}
