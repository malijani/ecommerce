<?php
namespace App\Mailers;
use App\Ticket;
use Illuminate\Contracts\Mail\Mailer;

class AppMailer
{
    protected $mailer;
    protected $fromAddress;
    protected $fromName;
    protected $to;
    protected $subject;
    protected $view;
    protected $data = [];

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendTicketInformation($user, Ticket $ticket)
    {
        $this->fromAddress = env('MAIL_FROM_ADDRESS');
        $this->fromName = env('MAIL_FROM_NAME');
        $this->to = $user->email;
        $this->subject = "[آیدی تیکت: $ticket->uuid] $ticket->title";
        $this->view = 'mails.ticket_info';
        $this->data = compact('user', 'ticket');

        return $this->deliver();
    }

    public function deliver()
    {
        $this->mailer->send($this->view, $this->data, function ($message) {
            $message->from($this->fromAddress, $this->fromName)
                ->to($this->to)->subject($this->subject);
        });
    }
}
