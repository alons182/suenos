<?php namespace app\controllers\Admin;

use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Laracasts\Flash\Flash;
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
        if (! isset($data['year']))
        {
            $data = array_add($data, 'year', Carbon::now()->year);
        }
        $data['q'] = (isset($data['q'])) ? trim($data['q']) : '';

        $payments = $this->paymentRepository->getPayments($data);

        return \View::make('admin.payments.index')->with([
            'payments'      => $payments,
            'selectedMonth' => $data['month'],
            'selectedYear' => $data['year'],
            'search'           => $data['q']
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
        return \View::make('admin.payments.create');
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
        $data['user_id'] =  $data['user_id_payment'];
        $data['transfer_date'] = $data['transfer_date_submit'];

        $this->paymentForm->validate($data);

        if(!$this->paymentRepository->store($data))
            Flash::error('Ya existe un pago para este mes.');
        else
            Flash::message('Pago agregado correctamente');

        return \Redirect::back();
    }

    /**
     * Show the form for editing the specified resource.
     * GET /payments/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $payment = $this->paymentRepository->findById($id);

        return \View::make('admin.payments.edit')->withPayment($payment);
    }

    /**
     * Update the specified resource in storage.
     * PUT /payments/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {

       if(Input::get('name') == 'amount')
       {
           $data['amount'] = Input::get('value');
       }else
       {
          $data['gain'] = Input::get('value');
       }

        $this->paymentRepository->update($id, $data);

        return 'ok';
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /payment/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->paymentRepository->destroy($id);

        Flash::message('Payment Deleted');

        return \Redirect::route('store.admin.payments.index');
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