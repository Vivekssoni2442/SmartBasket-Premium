<?php

namespace App\Mail;

use App\Models\SellerProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SellerVerificationDecisionMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public SellerProfile $seller, public string $decision) {}

    public function build(): self
    {
        $subject = $this->decision === 'approved'
            ? 'Your SmartBasket seller application has been approved'
            : 'Update on your SmartBasket seller application';

        return $this->subject($subject)->view('emails.seller-verification-decision');
    }
}
