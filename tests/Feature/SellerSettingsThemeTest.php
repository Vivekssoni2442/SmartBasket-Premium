<?php

namespace Tests\Feature;

use App\Models\SellerProfile;
use App\Models\Product;
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

    public function test_seller_payout_details_are_saved_without_marking_them_verified(): void
    {
        $seller = $this->seller();

        $this->withSession(['seller_login' => true, 'seller_id' => $seller->id])
            ->put(route('seller.settings.update'), [
                'theme' => 'light',
                'online_payments_enabled' => true,
                'payment_upi_id' => 'shop@exampleupi',
                'payment_mobile_number' => '9999999999',
                'payment_business_name' => 'Theme Shop',
            ])
            ->assertSessionHas('success');

        $seller->refresh();

        $this->assertSame('shop@exampleupi', $seller->payment_upi_id);
        $this->assertSame('9999999999', $seller->payment_mobile_number);
        $this->assertSame('Theme Shop', $seller->payment_business_name);
        $this->assertSame('verification_pending', $seller->payment_verification_status);
        $this->assertNull($seller->payment_verified_at);
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

    public function test_product_page_uses_only_the_qr_of_its_actual_seller(): void
    {
        Storage::fake('public');
        $sellerA = $this->seller(['email' => 'seller-a@example.com']);
        $sellerB = $this->seller(['email' => 'seller-b@example.com']);
        Storage::disk('public')->put('seller-payment-qr/a.png', 'seller-a-qr');
        Storage::disk('public')->put('seller-payment-qr/b.png', 'seller-b-qr');
        $sellerA->update(['payment_qr' => 'seller-payment-qr/a.png']);
        $sellerB->update(['payment_qr' => 'seller-payment-qr/b.png']);

        $product = Product::create([
            'seller_id' => $sellerA->id,
            'name' => 'Seller A product',
            'category' => 'Test',
            'price' => 100,
            'stock' => 1,
            'status' => 'active',
        ]);

        $this->get(route('products.show', $product))
            ->assertOk()
            ->assertSee(Storage::disk('public')->url('seller-payment-qr/a.png'))
            ->assertDontSee(Storage::disk('public')->url('seller-payment-qr/b.png'));
    }

    public function test_product_page_includes_its_uploaded_video_in_the_media_gallery(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('product-videos/demo.mp4', 'video-content');
        $seller = $this->seller();
        $product = Product::create([
            'seller_id' => $seller->id,
            'name' => 'Video product',
            'category' => 'Test',
            'price' => 100,
            'stock' => 1,
            'image' => null,
            'status' => 'active',
        ]);
        $product->videos()->create([
            'path' => 'product-videos/demo.mp4',
            'mime_type' => 'video/mp4',
        ]);

        $this->get(route('products.show', $product))
            ->assertOk()
            ->assertSee('mainProductVideo')
            ->assertSee('product-videos/demo.mp4')
            ->assertSeeHtml('preload="metadata"');
    }

    public function test_seller_cannot_open_another_sellers_product_editor(): void
    {
        $owner = $this->seller(['email' => 'product-owner@example.com']);
        $otherSeller = $this->seller(['email' => 'other-seller@example.com']);
        $product = Product::create([
            'seller_id' => $owner->id,
            'name' => 'Private seller product',
            'category' => 'Test',
            'price' => 100,
            'stock' => 1,
        ]);

        $this->withSession(['seller_login' => true, 'seller_id' => $otherSeller->id])
            ->get(route('seller.product.edit', $product->id))
            ->assertNotFound();
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
