<?php

namespace App\Mail;

use App\Models\SellerProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class SellerApplicationSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public SellerProfile $seller;

    public string $acceptUrl;
    public string $rejectUrl;

    public function __construct(SellerProfile $seller)
    {
        $this->seller = $seller;

        $this->acceptUrl = URL::temporarySignedRoute(
            'admin.seller-verifications.email.accept',
            now()->addDays(7),
            [
                'seller' => $seller->id,
            ]
        );

        $this->rejectUrl = URL::temporarySignedRoute(
            'admin.seller-verifications.email.reject',
            now()->addDays(7),
            [
                'seller' => $seller->id,
            ]
        );
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'SMART BASKET - New Seller Application - ' . $this->seller->name
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.seller-application-submitted'
        );
    }

    public function attachments(): array
    {
        $attachments = [];

        $documents = [
            'Business Certificate' => $this->seller->business_certificate_path,
            'Aadhaar Document'     => $this->seller->aadhaar_document_path,
            'PAN Document'         => $this->seller->pan_document_path,
            'Shop Proof'           => $this->seller->shop_proof_path,
            'Bank Proof'           => $this->seller->bank_proof_path,
        ];

        foreach ($documents as $name => $path) {

            if (
                filled($path) &&
                Storage::disk('local')->exists($path)
            ) {
                $attachments[] = \Illuminate\Mail\Mailables\Attachment::fromPath(
                    Storage::disk('local')->path($path)
                )->as(
                    $this->safeFileName($name, $path)
                );
            }
        }

        return $attachments;
    }

    private function safeFileName(
        string $name,
        string $path
    ): string {
        $extension = pathinfo(
            $path,
            PATHINFO_EXTENSION
        );

        return $name . ($extension ? '.' . $extension : '');
    }
}