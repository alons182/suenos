<?php namespace Suenos\Mailers;


class ContactMailer extends Mailer{

    protected $listLocalEmail = ['alonso@avotz.com'];
    protected $listProductionEmail = ['alons182@gmail.com'];

    public function contact($data)
    {
        $view = 'emails.contact.contact';
        $subject = 'Información desde formulario de contacto de Sueños de vida';
        $emailTo = $this->listLocalEmail;
        return $this->sendTo($emailTo, $subject, $view, $data);
    }
} 