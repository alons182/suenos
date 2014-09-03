<?php namespace Suenos\Profiles;

use Laracasts\Presenter\Presenter;

class ProfilePresenter extends Presenter {

    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }


}
