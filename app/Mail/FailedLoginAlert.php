<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FailedLoginAlert extends Mailable
{
    use Queueable, SerializesModels;


    public function build()
    {
        return $this
            ->subject('Smart Basket Security Alert')
            ->view('emails.failed-login');
    }
}