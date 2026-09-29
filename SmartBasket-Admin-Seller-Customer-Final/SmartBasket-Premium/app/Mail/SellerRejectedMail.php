<?php

namespace App\Mail;

use App\Models\SellerProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SellerRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public SellerProfile $seller;

    public function __construct(SellerProfile $seller)
    {
        $this->seller = $seller;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'SMART BASKET - Seller Application Rejected'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.seller-rejected'
        );
    }
}