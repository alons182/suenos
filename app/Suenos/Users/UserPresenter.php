<?php namespace Suenos\Users;

use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter {

    public function accountAge()
    {
        return $this->created_at->diffForHumans();
    }




}