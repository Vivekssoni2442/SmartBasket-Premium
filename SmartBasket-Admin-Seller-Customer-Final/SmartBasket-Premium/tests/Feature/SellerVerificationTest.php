<?php

namespace Tests\Feature;

use App\Mail\SellerVerificationCodeMail;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SellerVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_pending_seller_is_redirected_to_email_verification_from_dashboard(): void
    {
        $seller = $this->seller(['verification_status' => SellerProfile::STATUS_PENDING_EMAIL]);

        $this->withSession(['seller_login' => true, 'seller_id' => $seller->id])
            ->get('/seller-dashboard')
            ->assertRedirect(route('seller.verification.email'));
    }

    public function test_email_verification_code_is_sixteen_digits_hashed_and_one_time_use(): void
    {
        Mail::fake();
        $seller = $this->seller(['verification_status' => SellerProfile::STATUS_PENDING_EMAIL]);
        $session = ['seller_login' => true, 'seller_id' => $seller->id];
        $code = null;

        $this->withSession($session)
            ->post(route('seller.verification.email.send'), ['email' => $seller->email])
            ->assertSessionHas('success');

        Mail::assertSent(SellerVerificationCodeMail::class, function (SellerVerificationCodeMail $mail) use (&$code) {
            $code = $mail->code;

            return $mail->purpose === 'email' && preg_match('/^\d{16}$/', $mail->code) === 1;
        });

        $seller->refresh();
        $this->assertNotSame($code, $seller->email_code_hash);
        $this->assertTrue(Hash::check($code, $seller->email_code_hash));

        $this->withSession($session)
            ->post(route('seller.verification.email.verify'), ['code' => $code])
            ->assertRedirect(route('seller.verification.documents'));

        $seller->refresh();
        $this->assertSame(SellerProfile::STATUS_EMAIL_VERIFIED, $seller->verification_status);
        $this->assertNull($seller->email_code_hash);
    }

    public function test_non_admin_customer_cannot_access_seller_verification_management(): void
    {
        config(['services.seller_verification.admin_emails' => 'admin@example.test']);
        $customer = User::factory()->create(['email' => 'customer@example.test']);

        $this->actingAs($customer)
            ->get('/admin/seller-verifications')
            ->assertForbidden();
    }

    private function seller(array $attributes = []): SellerProfile
    {
        return SellerProfile::create(array_merge([
            'seller_name' => 'Verification Seller',
            'shop_name' => 'Verification Shop',
            'email' => 'seller@example.test',
            'mobile_number' => '9999999999',
            'password' => Hash::make('Password1!'),
        ], $attributes));
    }
}
