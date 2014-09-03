<?php namespace Suenos\Users;

use Suenos\DbRepository;
use Suenos\Roles\Role;


class DbUserRepository extends DbRepository implements UserRepository  {

    protected $model;

    function __construct(User $model)
    {
        $this->model = $model;
    }

    /** Save the user with a blank profile
     * @param $data
     * @return mixed
     */
    public function store($data)
    {

        if(!$data['parent_id'])
        {
            $data = array_except($data, array('parent_id'));
        }

       // dd($data);
        $user = $this->model->create($data);

      //  dd($user);
        $role = (isset($data['role'])) ? $data['role'] : Role::whereName('member')->first();

        $user->createProfile();
        $user->assignRole($role);

        return $user;
    }

    /** Find User with your profile by Username
     * @param $username
     * @return mixed
     */
    public function findByUsername($username)
    {
        return $this->model->with('roles')->with('profiles')->whereUsername($username)->firstOrFail();
    }


}