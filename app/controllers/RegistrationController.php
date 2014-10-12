<?php
use Suenos\Forms\RegistrationForm;
use Suenos\Mailers\UserMailer;
use Suenos\Users\UserRepository;

class RegistrationController extends \BaseController {

    protected $registrationForm;
    protected $userRepository;
    /**
     * @var UserMailer
     */
    private $mailer;

    function __construct(RegistrationForm $registrationForm, UserRepository $userRepository, UserMailer $mailer)
    {
        $this->registrationForm = $registrationForm;
        $this->userRepository = $userRepository;
        $this->mailer = $mailer;
    }


    /**
     * Show the form for creating a new resource.
     * GET /registration/create
     *
     * @param null $username
     * @return Response
     */
    public function create($username = null)
    {
        $user = ($username) ? $this->userRepository->findByUsername($username) : null;

        return View::make('registration.create')->withParent_user($user);
    }

    /**
     * Store a newly created resource in storage.
     * POST /registration
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::only('username', 'email', 'password', 'password_confirmation', 'parent_id', 'terms');

        $this->registrationForm->validate($input);
        $user = $this->userRepository->store($input);

        Auth::login($user);

        Flash::message('Complete your profile, its very important !');

        $this->mailer->sendWelcomeMessageTo($user);


        return Redirect::route('profile.edit', $user->username);
    }


}