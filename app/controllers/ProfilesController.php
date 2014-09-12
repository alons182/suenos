<?php

use Suenos\Forms\ProfileForm;
use Suenos\Users\UserRepository;

class ProfilesController extends \BaseController {

    protected $profileForm;
    protected $userRepository;
    function __construct(UserRepository $userRepository, ProfileForm $profileForm)
    {
        $this->userRepository = $userRepository;
        $this->profileForm = $profileForm;

        $this->beforeFilter('currentUser',['only' => ['edit','update']]);
    }

    /**
     * Display the specified resource.
     * GET /profiles/{id}
     *
     * @param $username
     * @return Response
     */
	public function show($username)
	{
        $user = $this->userRepository->findByUsername($username);

        return View::make('profiles.show')->withUser($user);
    }

    /**
     * Show the form for editing the specified resource.
     * GET /profiles/{id}/edit
     *
     * @param $username
     * @internal param int $id
     * @return Response
     */
	public function edit($username)
	{
        $user = $this->userRepository->findByUsername($username);
       
        return View::make('profiles.edit')->withUser($user);
	}

    /**
     * Update the specified resource in storage.
     * PUT /profiles/{id}
     *
     * @param $username
     * @internal param int $id
     * @return Response
     */
	public function update($username)
	{
        $user = $this->userRepository->findByUsername($username);
        $input = Input::all();
        $this->profileForm->validate($input);
        $user->profiles->fill($input)->save();

        Flash::message('Profile Updated !');
        return Redirect::route('profile.edit', $user->username);
	}


}