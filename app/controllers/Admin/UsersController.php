<?php namespace app\controllers\Admin;

use Input;
use Laracasts\Flash\Flash;
use Suenos\Forms\UserEditForm;
use Suenos\Forms\UserForm;
use Suenos\Users\UserRepository;
use User;
use Auth;



class UsersController extends \BaseController {

    protected $userForm;
    protected $userRepository;
    protected $userEditForm;

    /**
     * @param UserForm $userForm
     * @param UserEditForm $userEditForm
     * @param UserRepository $userRepository
     * @internal param UserEditForm $
     */

    function __construct(UserForm $userForm,UserEditForm $userEditForm, UserRepository $userRepository)
    {
        $this->userForm = $userForm;
        $this->userRepository = $userRepository;
        $this->userEditForm = $userEditForm;
    }

    /**
     * Display a listing of the resource.
     * GET /users
     *
     * @return Response
     */
    public function index()
    {
        $search = Input::all();
        if (! count($search) > 0)
        {
            $search['q'] = "";
        }

        $users = $this->userRepository->findAll($search);

        return \View::make('admin.users.index')->with([
            'users'  => $users,
            'search' => $search['q']

        ]);
    }

    /**
     * Show the form for creating a new resource.
     * GET /users/create
     *
     * @return Response
     */
    public function create()
    {
        return \View::make('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     * POST /users
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::only('username', 'email', 'password', 'password_confirmation', 'role','parent_id');
        $this->userForm->validate($input);
        $this->userRepository->store($input);

        Flash::message('User created');

        return \Redirect::route('users');
    }


    /**
     * Show the form for editing the specified resource.
     * GET /users/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->findById($id);

        return \View::make('admin.users.edit')->withUser($user);
    }

    /**
     * Update the specified resource in storage.
     * PUT /users/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $input = Input::only('username', 'email', 'password', 'password_confirmation', 'role', 'parent_id');
        $this->userEditForm->validate($input);
        $this->userRepository->update($id, $input);

        Flash::message('User updated');

        return \Redirect::route('users');
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /users/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->userRepository->destroy($id);

        return \Redirect::route('users')->with([
            'flash_message' => 'User Delete',
            'flash_type'    => 'alert-success'
        ]);;
    }

}