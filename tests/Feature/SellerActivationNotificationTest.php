<?php

namespace Tests\Feature;

use App\Mail\SellerActivatedAdminMail;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SellerActivationNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_activation_sends_the_admin_summary_only_after_seller_becomes_active(): void
    {
        Mail::fake();
        config(['services.seller_verification.admin_seller_email' => 'admin@example.test']);
        $seller = $this->seller();
        $code = '1234567890123456';
        $seller->update(['activation_code_hash' => Hash::make($code), 'activation_code_expires_at' => now()->addMinutes(10)]);

        $this->withSession(['seller_login' => true, 'seller_id' => $seller->id])
            ->post(route('seller.activation.verify'), ['code' => $code])
            ->assertRedirect(route('seller.dashboard'));

        $this->assertSame(SellerProfile::STATUS_ACTIVE, $seller->fresh()->verification_status);
        Mail::assertSent(SellerActivatedAdminMail::class, fn ($mail) => $mail->hasTo('admin@example.test'));
    }

    public function test_onboarding_is_private_to_the_current_seller_and_admin_detail_is_protected(): void
    {
        $seller = $this->seller(['verification_status' => SellerProfile::STATUS_PENDING_EMAIL]);
        $this->withSession(['seller_login' => true, 'seller_id' => $seller->id])->get(route('seller.onboarding'))->assertOk();
        $this->actingAs(User::factory()->create())->get(route('admin.sellers.show', $seller))->assertForbidden();
    }

    private function seller(array $attributes = []): SellerProfile
    {
        return SellerProfile::create(array_merge(['seller_name' => 'Seller', 'shop_name' => 'Shop', 'email' => 'seller@example.test', 'mobile_number' => '9999999999', 'password' => Hash::make('Password1!'), 'verification_status' => SellerProfile::STATUS_APPROVED], $attributes));
    }
}
