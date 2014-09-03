<?php namespace Suenos\Profiles;


use Laracasts\Presenter\PresentableTrait;

class Profile extends \Eloquent {

    use PresentableTrait;
    protected $table = 'profiles';

    /**
     * Path to presenter for a profile
     * @var string
     */
    protected $presenter = 'Suenos\Profiles\ProfilePresenter';

    protected $fillable = [
        'first_name','last_name','ide','address','code_zip','telephone','country','estate',
        'city','bank','type_account','number_account','nit','skype'
    ];

    public function users()
    {
        return $this->belongsTo('Suenos\Users\User');
    }
} 