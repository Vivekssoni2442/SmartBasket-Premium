<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SellerVerificationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $code;
    public string $purpose;

    public function __construct(string $code, string $purpose = 'email')
    {
        $this->code = $code;
        $this->purpose = $purpose;
    }

    public function build(): self
    {
        $subject = $this->purpose === 'activation'
            ? 'SMART BASKET - Seller Activation Code'
            : 'SMART BASKET - Seller Email Verification Code';

        return $this
            ->from(
                config('mail.from.address'),
                config('mail.from.name', 'SMART BASKET')
            )
            ->subject($subject)
            ->view('emails.seller-verification-code')
            ->with([
                'code' => $this->code,
                'purpose' => $this->purpose,
            ]);
    }
}