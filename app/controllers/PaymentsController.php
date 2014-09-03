<?php

use Suenos\Forms\PaymentForm;
use Suenos\Payments\PaymentRepository;
use Suenos\Users\UserRepository;

class PaymentsController extends \BaseController {

    protected $userRepository;
    /**
     * @var Suenos\Payments\PaymentRepository
     */
    private $paymentRepository;
    /**
     * @var Suenos\Forms\PaymentForm
     */
    private $paymentForm;

    function __construct(UserRepository $userRepository, PaymentRepository $paymentRepository, PaymentForm $paymentForm)
    {
        $this->userRepository = $userRepository;
        $this->paymentRepository = $paymentRepository;
        $this->paymentForm = $paymentForm;
        $this->limit = 10;
        $this->beforeFilter('auth');
    }

    /**
     * Display a listing of the payments (balance).
     * GET /balances
     *
     * @return Response
     */
	public function index()
	{
        $payments = $this->paymentRepository->getPaymentsOfYourRed($this->limit);

        return View::make('payments.index')->withPayments($payments);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /balances/create
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('payments.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /balances
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::all();
        
        $this->paymentForm->validate($data);
        
        $this->paymentRepository->store($data);

        Flash::message('Pago agregado correctamente');

        return Redirect::back();
	}

    /**
     * Display the specified resource.
     * GET /balances/{username}
     *
     * @param $username
     * @return Response
     */
	public function show($username)
	{

	}

    /**
     * Display the specified resource.
     * GET /red
     *
     * @return Response
     */
    public function red()
    {


        return View::make('users.red');//->withUser($user);

    }
	/**
	 * Show the form for editing the specified resource.
	 * GET /balances/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /balances/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /balances/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}