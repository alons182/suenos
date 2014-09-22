<?php

use Carbon\Carbon;
use Suenos\Categories\Category;

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}

        View::share('currentUser', Auth::user());
        View::share('currentMonth', Carbon::now()->month);
        View::share('categories', Category::all());
	}



}
