<?php namespace Suenos\Mailers;


use Suenos\Orders\Order;

class OrderMailer extends Mailer{

    protected $listLocalEmail = ['alonso@avotz.com'];
    protected $listProductionEmail = ['alons182@gmail.com'];

    public function sendConfirmMessageOrder(Order $order, $data = null)
    {
        $view = 'emails.orders.confirm';
        $subject = 'Orden creada';
        $emailTo =$this->listLocalEmail;
        $data['orderId'] = $order->id;
        $data += $order->toArray();

        return $this->sendTo($emailTo, $subject, $view, $data);
    }
} 