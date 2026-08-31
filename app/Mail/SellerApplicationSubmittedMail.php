<?php

namespace App\Mail;

use App\Models\SellerProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class SellerApplicationSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public SellerProfile $seller;
    public string $maskedAadhaar;
    public string $maskedBankAccount;
    public string $viewUrl;
    public string $approveUrl;
    public string $rejectUrl;

    public function __construct(SellerProfile $seller)
    {
        $this->seller = $seller;
        $this->maskedAadhaar = $this->mask($seller->aadhaar_number, 4);
        $this->maskedBankAccount = $this->mask($seller->bank_account_number, 4);
        $this->viewUrl = route('admin.seller-verifications.show', ['seller' => $seller->id]);
        $this->approveUrl = route('admin.seller-verifications.show', ['seller' => $seller->id, 'action' => 'approve']);
        $this->rejectUrl = route('admin.seller-verifications.show', ['seller' => $seller->id, 'action' => 'reject']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'SMART BASKET - New Seller Partner Application');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.seller-application-submitted');
    }

    public function attachments(): array
    {
        $attachments = [];
        $documents = [
            'Business Certificate' => $this->seller->business_certificate_path,
            'Aadhaar Document' => $this->seller->aadhaar_document_path,
            'PAN Document' => $this->seller->pan_document_path,
            'Shop Proof' => $this->seller->shop_proof_path,
            'Bank Proof' => $this->seller->bank_proof_path,
        ];

        foreach ($documents as $name => $path) {
            if ($path && Storage::disk('public')->exists($path)) {
                $extension = pathinfo($path, PATHINFO_EXTENSION);
                $attachments[] = Attachment::fromPath(Storage::disk('public')->path($path))
                    ->as($name . ($extension ? '.' . $extension : ''));
            }
        }

        return $attachments;
    }

    private function mask(?string $value, int $visible): string
    {
        $value = preg_replace('/\s+/', '', (string) $value);
        if ($value === '') {
            return 'Not provided';
        }

        return str_repeat('*', max(strlen($value) - $visible, 0)) . substr($value, -$visible);
    }
}
