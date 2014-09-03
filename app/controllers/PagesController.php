<?php


use Suenos\Forms\ContactForm;
use Suenos\Mailers\ContactMailer;

class PagesController extends \BaseController {


    /**
     * @var Suenos\Mailers\ContactMailer
     */
    private $mailer;
    /**
     * @var Suenos\Forms\ContactForm
     */
    private $contactForm;

    function __construct(ContactMailer $mailer, ContactForm $contactForm)
    {

        $this->mailer = $mailer;
        $this->contactForm = $contactForm;
    }


    /**
	 * Display a home page.
	 * GET /pages
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('pages.index');
	}

	/**
	 * Display about page
	 *
	 * @return Response
	 */
	public function about()
	{
		return View::make('pages.about');
	}

    /**
     * Display oportunity page
     *
     * @return Response
     */
    public function opportunity()
    {
        return View::make('pages.opportunity');
    }

    /**
     * Page Plan de ayuda
     * @return mixed
     */
    public function  aid()
    {
        return View::make('pages.aid_plan');
    }

    /**
     * Page terms & conditions
     * @return mixed
     */
    public function  terms()
    {
        return View::make('pages.terms');
    }


    /**
     * Page Contact us
     * @return mixed
     */
    public function contact()
    {
        return View::make('pages.contact');

    }

    /**
     * Page Contact us Post
     * @return mixed
     */
    public function postContact()
    {
        $data = Input::all();
        $this->contactForm->validate($data);
        $this->mailer->contact($data);

        Flash::message('Mensaje enviado correctamente');

        return Redirect::route('contact');
    }


}