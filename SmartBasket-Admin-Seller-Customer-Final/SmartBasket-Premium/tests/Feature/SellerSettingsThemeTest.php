<?php

namespace Tests\Feature;

use App\Models\SellerProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SellerSettingsThemeTest extends TestCase
{
    use RefreshDatabase;

    public function test_seller_settings_persist_the_selected_theme_and_preferences(): void
    {
        $seller = $this->seller();

        $this->withSession(['seller_login' => true, 'seller_id' => $seller->id])
            ->put(route('seller.settings.update'), [
                'theme' => 'dark',
                'notifications_enabled' => false,
                'online_payments_enabled' => false,
            ])
            ->assertSessionHas('success');

        $seller->refresh();

        $this->assertSame('dark', $seller->theme);
        $this->assertFalse((bool) $seller->notifications_enabled);
        $this->assertFalse((bool) $seller->online_payments_enabled);
    }

    public function test_seller_can_upload_and_delete_payment_qr(): void
    {
        $seller = $this->seller();

        Storage::fake('public');

        $this->withSession(['seller_login' => true, 'seller_id' => $seller->id])
            ->post(route('seller.payment-qr.update'), [
                'payment_qr' => UploadedFile::fake()->create('qr.png', 200, 'image/png'),
            ])
            ->assertSessionHas('success');

        $seller->refresh();

        $this->assertNotNull($seller->payment_qr);
        $this->assertTrue(Storage::disk('public')->exists($seller->payment_qr));

        $this->withSession(['seller_login' => true, 'seller_id' => $seller->id])
            ->delete(route('seller.payment-qr.delete'))
            ->assertSessionHas('success');

        $seller->refresh();

        $this->assertNull($seller->payment_qr);
    }

    private function seller(array $attributes = []): SellerProfile
    {
        return SellerProfile::create(array_merge([
            'seller_name' => 'Theme Seller',
            'shop_name' => 'Theme Shop',
            'email' => 'theme-seller@example.com',
            'mobile_number' => '9999999999',
            'password' => Hash::make('Password1!'),
            'theme' => 'light',
            'notifications_enabled' => true,
            'online_payments_enabled' => true,
        ], $attributes));
    }
}
