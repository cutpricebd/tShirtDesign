<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderRefundMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $order;
    public $refund_amount;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $order, $refund_amount)
    {
        $this->subject = $subject;
        $this->order = $order;
        $this->refund_amount = $refund_amount;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->view('email.order-refund');
    }
}
