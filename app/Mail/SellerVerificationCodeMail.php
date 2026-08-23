<?php
namespace App\Mail;
use Illuminate\Bus\Queueable; use Illuminate\Mail\Mailable; use Illuminate\Queue\SerializesModels;
class SellerVerificationCodeMail extends Mailable { use Queueable, SerializesModels; public function __construct(public string $code, public string $purpose) {} public function build(): self { return $this->subject($this->purpose === 'activation' ? 'Your SmartBasket Seller Activation Code' : 'Your SmartBasket Seller Verification Code')->view('emails.seller-verification-code'); } }
