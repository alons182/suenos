<?php namespace Suenos\Users;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laracasts\Presenter\PresentableTrait;
//use Kalnoy\Nestedset\Node;
use Suenos\Profiles\Profile;
use Baum\Node;

class User extends Node implements UserInterface, RemindableInterface  {

	use UserTrait, RemindableTrait, PresentableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

    /**
     * Path to presenter for a user
     * @var string
     */
    protected $presenter = 'Suenos\Users\UserPresenter';

    protected $fillable = [

        'username','email','password','parent_id'
    ];


	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');


    public function scopeSearch($query, $search)
    {
        return $query->where(function($query) use ($search)
        {
            $query->where('username', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%');
        });
    }
    /**
     * Set Hash password
     * @param $password
     * @return string
     */
    public function setPasswordAttribute($password)
    {
        if(!empty($password))
            $this->attributes['password'] = Hash::make($password);

    }

    /*public function parent()
    {
        return $this->belongsTo('User', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('User', 'parent_id');
    }*/
    public function orders()
    {
        return $this->hasMany('Suenos\Orders\Order')->latest();
    }
    public function payments()
    {
        return $this->hasMany('Suenos\Payments\Payment');
    }
    public function profiles()
    {
        return $this->hasOne('Suenos\Profiles\Profile');
    }
    public function createProfile($profile = null)
    {
        $profile = ($profile) ? $profile : new Profile();

        return $this->profiles()->save($profile);
    }
    public function roles()
    {
        return $this->belongsToMany('Suenos\Roles\Role')->withTimesTamps();
    }
    public function isCurrent()
    {
        if(Auth::guest()) return false;

        return Auth::user()->id == $this->id;
    }
    public function hasRole($name)
    {
        foreach ($this->roles as $role)
        {
            if($role->name == $name) return true;
        }

        return false;

    }
    public function assignRole($role)
    {
        return $this->roles()->attach($role);
    }
    public function removeRole($role)
    {
        return $this->roles()->detach($role);
    }


}
