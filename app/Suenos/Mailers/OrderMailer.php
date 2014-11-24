<?php namespace Suenos\Mailers;


use Suenos\Orders\Order;

class OrderMailer extends Mailer{

    protected $listLocalEmail = ['alonso@avotz.com'];
    protected $listProductionEmail = ['tienda@suenosdevidacr.com'];

    public function sendConfirmMessageOrder(Order $order, $data = null)
    {
        $view = 'emails.orders.confirm';
        $subject = 'Orden creada';
        $emailTo =$this->listProductionEmail;
        $data['orderId'] = $order->id;
        $data += $order->toArray();

        return $this->sendTo($emailTo, $subject, $view, $data);
    }
} 