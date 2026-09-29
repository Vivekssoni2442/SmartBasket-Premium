<?php

namespace App\Mail;

use App\Models\SellerProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class SellerActivatedAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public bool $documentsNotAttached = false;

    public function __construct(public SellerProfile $seller) {}

    public function build(): self
    {
        $mail = $this->subject('SmartBasket - New Seller Account Activated')
            ->view('emails.seller-activated-admin');
        $size = 0;
        foreach (['business_certificate_path', 'aadhaar_document_path', 'pan_document_path', 'shop_proof_path', 'bank_proof_path'] as $field) {
            $path = $this->seller->{$field};
            if (! $path || ! Storage::disk('local')->exists($path)) continue;
            $bytes = Storage::disk('local')->size($path);
            if ($size + $bytes > 5 * 1024 * 1024) { $this->documentsNotAttached = true; continue; }
            $size += $bytes;
            $mail->attach(Storage::disk('local')->path($path));
        }
        return $mail;
    }
}
