<?php namespace Suenos\Users;

use Carbon\Carbon;
use Suenos\Payments\Payment;
use Suenos\DbRepository;
use Suenos\Roles\Role;


class DbUserRepository extends DbRepository implements UserRepository  {

    protected $model;

    function __construct(User $model)
    {
        $this->model = $model;
        $this->limit = 10;
        $this->membership_cost = 20000;
    }

    /** Save the user with a blank profile
     * @param $data
     * @return mixed
     */
    public function store($data)
    {
        $parent_id = $data['parent_id'];
        $data = $this->prepareData($data);

        $user = $this->model->create($data);

      //  dd($user);
        $role = (isset($data['role'])) ? $data['role'] : Role::whereName('member')->first();

        $user->createProfile();
        $user->assignRole($role);

        $user = $this->bonus($user,$parent_id);

        return $user;
    }

    /**
     * Update user
     * @param $id
     * @param $data
     * @return \Illuminate\Support\Collection|static
     */
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

        if (! count($search) > 0) return $this->model->with('roles')->with('profiles')->paginate($this->limit);

        if (trim($search['q']))
        {
            $users = $this->model->Search($search['q']);
        }else
        {
            $users = $this->model;
        }

        if (isset($search['active']) && $search['active'] != "")
        {
            $users = $users->where('active', '=', $search['active']);
        }


        return $users->with('roles')->with('profiles')->paginate($this->limit);

    }

    public function getLasts()
    {
        return $this->model->orderBy('users.created_at', 'desc')
            ->limit(6)->get(['users.id', 'users.username']);
    }

    public function reportPaidsByMonth($month,$year)
    {

        $users = $this->model->with('profiles')->get();

        $usersArray = [];
        foreach ($users as $user)
        {
            $usersOfRed = $user->children()->get()->lists('id');

            if($usersOfRed)
            {
                $payments = Payment::where(function($query) use ($usersOfRed,$month,$year)
                {
                    $query->whereIn('user_id', $usersOfRed)
                     ->where(\DB::raw('MONTH(created_at)'), '=', $month )
                     ->where(\DB::raw('YEAR(created_at)'), '=', $year );
                });
                $gain = $payments->sum('gain') - (($payments->count()) ? $payments->first()->membership_cost : $this->membership_cost);



            } else{
                $gain = 0;
            }

            $userArray = array(
                'id' => $user->id,
                'Email' => $user->email,
                'Nombre' => $user->profiles->present()->fullname,
                'Cedula' => $user->profiles->ide,
                'Cuenta' => $user->profiles->number_account,
                'Monto' => $gain,
                'Mes' => $month,
                'Año' => $year
            );

            $usersArray[] = $userArray;

        }
        return $usersArray;

    }

    /**
     * @param $data
     * @return array
     */
    public function prepareData($data)
    {
       // if (! $data['parent_id'])
       // {
            $data = array_except($data, array('parent_id'));
       // }


        return $data;
    }

    /**
     * @param $user
     * @param $parent_id
     * @internal param $data
     * @return mixed
     */
    public function bonus($user,$parent_id)
    {
        if($parent_id)
        {
            $parent_user = $this->model->findOrFail($parent_id);

            if ($parent_user->depth != 0)
            {
                if ($parent_user->immediateDescendants()->count() == 4 && $parent_user->bonus != 1)
                {
                    $parent_user->bonus = 1;
                    $parent_user->save();
                    $this->bonus($user, $parent_user->parent_id);
                }
                else
                {
                    $user->parent_id = $parent_user->id;
                    $user->save();
                }
            }else
            {
                $user->parent_id = $parent_user->id;
                $parent_user->bonus = 1;
                $parent_user->save();
                $user->save();


            }


        }



        return $user;
    }
}