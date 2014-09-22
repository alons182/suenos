<?php namespace Suenos\Users;

use Suenos\DbRepository;
use Suenos\Roles\Role;


class DbUserRepository extends DbRepository implements UserRepository  {

    protected $model;

    function __construct(User $model)
    {
        $this->model = $model;
        $this->limit = 10;
    }

    /** Save the user with a blank profile
     * @param $data
     * @return mixed
     */
    public function store($data)
    {

        $data = $this->prepareData($data);

        // dd($data);
        $user = $this->model->create($data);

      //  dd($user);
        $role = (isset($data['role'])) ? $data['role'] : Role::whereName('member')->first();

        $user->createProfile();
        $user->assignRole($role);

        return $user;
    }

    public function update($id, $data)
    {
        $user = $this->model->findOrFail($id);
        $data = $this->prepareData($data);
        $roles[] = $data['role'];

        $user->fill($data);
        $user->save();
        $user->roles()->sync($roles);

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

    /** Find User with your profile by Username
     * @internal param $username
     * @param null $search
     * @return mixed
     */
    public function findAll($search = null)
    {
        if (! count($search) > 0) return $this->model;

        if (trim($search['q']))
        {
            $users = $this->model->Search($search['q']);
        } else
        {
            $users = $this->model;
        }

        return $users->with('roles')->with('profiles')->paginate($this->limit);

    }

    public function getLasts()
    {
        return $this->model->orderBy('users.created_at', 'desc')
            ->limit(6)->get(['users.id', 'users.username']);
    }

    /**
     * @param $data
     * @return array
     */
    public function prepareData($data)
    {
        if (! $data['parent_id'])
        {
            $data = array_except($data, array('parent_id'));

            return $data;
        }

        return $data;
    }
}