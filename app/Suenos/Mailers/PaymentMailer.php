<?php namespace Suenos\Mailers;


use Carbon\Carbon;
use Suenos\Users\User;

class PaymentMailer extends Mailer{

    protected $listLocalEmail = ['alonso@avotz.com'];
    protected $listProductionEmail = ['alons182@gmail.com'];

    public function sendPaymentsMembershipMessageTo(User $user)
    {
        $view = 'emails.payments.confirm';
        $subject = 'Cobro de membresia de sueños de vida!';
        $emailTo = $user->email;
        $data = $user->toArray();
        $data['month'] = Carbon::now()->month;
        $data['year'] = Carbon::now()->year;


        return $this->sendTo($emailTo, $subject, $view, $data);
    }
    public function sendReportMembershipMessageTo($users,$users_payments)
    {
        $view = 'emails.payments.report';
        $subject = 'Cobro de membresia de sueños de vida!';
        $emailTo = $this->listLocalEmail;
        $data['users'] =$users;
        $data['users_payments'] = $users_payments;


        return $this->sendTo($emailTo, $subject, $view, $data);
    }
} 