<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUs extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $name;
    public $email;
    public $mobile_number;
    public $message_text;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $name, $email, $mobile_number, $message)
    {
        $this->subject = $subject;
        $this->name = $name;
        $this->email = $email;
        $this->mobile_number = $mobile_number;
        $this->message_text = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->view('email.contact-us');
    }
}
