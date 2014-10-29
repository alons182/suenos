<?php

use Carbon\Carbon;
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
        $data = Input::all();
        if (! isset($data['month']))
        {
            $data = array_add($data, 'month', Carbon::now()->month);
        }

        $payments = $this->paymentRepository->getPaymentsOfYourRed($data);

        return View::make('payments.index')->with([
            'payments'      => $payments,
            'selectedMonth' => $data['month']
        ]);
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
        $data['transfer_date'] = $data['transfer_date_submit'];

        $this->paymentForm->validate($data);

        if(!$this->paymentRepository->store($data))
            Flash::error('Ya existe un pago para este mes.');
        else
            Flash::message('Pago agregado correctamente');

        return Redirect::back();
    }

    /**
     * Display the specified resource.
     * GET /red
     *
     * @return Response
     */
    public function red()
    {
        return View::make('users.red')->withMonth(Carbon::now()->month)->withYear(Carbon::now()->year);
    }


}