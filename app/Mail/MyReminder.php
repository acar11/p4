<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MyReminder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */

     public function build()
     {
     $address = 'acar11@gmail.com'; // TO
     $name = 'My Email Reminder';
     $subject = 'Email Reminder';

     return $this->view('emails.email')
                 ->from($address, $name)
                 //->cc($address, $name)
                 //->bcc($address, $name)
                 //->replyTo($address, $name)
                 ->subject($subject);
     }

    public function build_to_test()
    {
        //return $this->view('view.name');
        //return $this->view('emails.welcome');

        return $this->from('acar11@gmail.com')
                     ->view('emails.email');

    }
}
