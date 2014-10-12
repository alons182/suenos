<?php


use Suenos\Forms\OrderForm;
use Suenos\Mailers\OrderMailer;
use Suenos\Orders\OrderRepository;


class OrdersController extends BaseController {

    /**
     * @var OrderRepository
     */
    private $orderRepository;
    /**
     * @var OrderForm
     */
    private $orderForm;
    /**
     * @var OrderMailer
     */
    private $mailer;

    function __construct(OrderRepository $orderRepository, OrderForm $orderForm, OrderMailer $mailer)
    {
        $this->orderRepository = $orderRepository;
        $this->orderForm = $orderForm;
        $this->mailer = $mailer;
    }


    /**
	 * Display a listing of the resource.
	 * GET /orders
	 *
	 * @return Response
	 */
	public function index()
	{
        $data = Input::all();

        $orders = $this->orderRepository->findAll($data);

        return View::make('orders.index')->with([
            'orders'      => $orders

        ]);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /orders
	 *
	 * @return Response
	 */
	public function store()
	{
        $data_cart = Input::all();
        $data_form = json_decode(Session::get('data_form'),true);

        if($data_cart['itemCount']==0)
        {
            Flash::message('No hay items en el carrito');
            return Redirect::route('cart_path');
        }

        $order =  $this->orderRepository->store($data_cart);

        $this->mailer->sendConfirmMessageOrder($order,$data_form);

        Flash::message('Pago realizado con exito - orden '.$order->id);

        return Redirect::route('orders.index');
	}

	/**
	 * Display the specified resource.
	 * GET /orders/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $order =  $this->orderRepository->findById($id);

        return View::make('orders.show')->with([
            'order'      => $order

        ]);
	}

    public function cart()
    {
        return View::make('orders.cart');
    }

    /**
     * show the form checkout
     * @return mixed
     */
    public function formCheckout()
    {
        return View::make('orders.checkout');
    }

    /**
     * Post form checkout
     * @return mixed
     * @throws \Laracasts\Validation\FormValidationException
     */
    public function formPostCheckout()
    {

        $data = array_except(Input::all(), array('_token'));

        $this->orderForm->validate($data);

        Session::forget('data_form');
        Session::put('data_form',json_encode($data) );


        return View::make('orders.checkoutFinal')->withData($data);


    }





}