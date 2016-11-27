<?php

namespace App\Mail;

use App\Order;
use Illuminate\Mail\Mailable;

class ExampleMail extends Mailable
{
    /**
     * Create a new mail instance.
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
        // return $this->to('john@example.com')->view('emails.example');
    }
}