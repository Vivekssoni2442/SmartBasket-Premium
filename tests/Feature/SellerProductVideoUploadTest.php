<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\SellerProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SellerProductVideoUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_seller_can_create_product_with_video(): void
    {
        $seller = $this->seller();
        $image = $this->fakePng();

        $this->withSession($this->sellerSession($seller))
            ->post(route('seller.product.store'), $this->productFields([
                'image' => $image,
                'video' => UploadedFile::fake()->create('demo.mp4', 500, 'video/mp4'),
            ]))
            ->assertRedirect('/seller-dashboard');

        $product = Product::where('seller_id', $seller->id)->firstOrFail();
        $this->assertNotEmpty($product->video);
        Storage::disk('public')->assertExists($product->video);
        $this->assertNotEmpty($product->image);
        $imagePath = public_path('products/' . $product->image);
        $this->assertFileExists($imagePath);
        unlink($imagePath);
    }

    public function test_seller_can_upload_an_optional_poster_with_a_video(): void
    {
        $seller = $this->seller();

        $this->withSession($this->sellerSession($seller))
            ->post(route('seller.product.store'), $this->productFields([
                'image' => $this->fakePng(),
                'video' => UploadedFile::fake()->create('demo.mp4', 500, 'video/mp4'),
                'video_poster' => $this->fakePng(),
            ]))
            ->assertRedirect('/seller-dashboard');

        $product = Product::where('seller_id', $seller->id)->firstOrFail();
        $this->assertNotEmpty($product->video_poster);
        Storage::disk('public')->assertExists($product->video_poster);
    }

    public function test_customer_product_page_uses_saved_video_and_poster(): void
    {
        $seller = $this->seller();
        $product = $this->product($seller, 'product-videos/demo.mp4');
        $product->update(['video_poster' => 'product-video-posters/demo.png']);
        Storage::disk('public')->put($product->video, 'video');
        Storage::disk('public')->put($product->video_poster, 'poster');

        $this->get(route('products.show', $product))
            ->assertOk()
            ->assertSee('storage/product-videos/demo.mp4')
            ->assertSee('storage/product-video-posters/demo.png');
    }

    public function test_seller_can_replace_video_and_old_file_is_removed_after_save(): void
    {
        $seller = $this->seller();
        $product = $this->product($seller, 'product-videos/old.mp4');
        Storage::disk('public')->put('product-videos/old.mp4', 'old-video');

        $this->withSession($this->sellerSession($seller))
            ->post(route('seller.product.update', $product->id), $this->productFields([
                'video' => UploadedFile::fake()->create('replacement.webm', 500, 'video/webm'),
            ]))
            ->assertRedirect('/seller-dashboard');

        $product->refresh();
        $this->assertNotSame('product-videos/old.mp4', $product->video);
        $this->assertSame('existing.jpg', $product->image);
        Storage::disk('public')->assertExists($product->video);
        Storage::disk('public')->assertMissing('product-videos/old.mp4');
    }

    public function test_seller_can_edit_without_replacing_existing_video(): void
    {
        $seller = $this->seller();
        $product = $this->product($seller, 'product-videos/keep.mp4');
        Storage::disk('public')->put('product-videos/keep.mp4', 'existing-video');

        $this->withSession($this->sellerSession($seller))
            ->post(route('seller.product.update', $product->id), $this->productFields())
            ->assertRedirect('/seller-dashboard');

        $this->assertSame('product-videos/keep.mp4', $product->fresh()->video);
        Storage::disk('public')->assertExists('product-videos/keep.mp4');
    }

    public function test_seller_can_open_the_product_edit_page(): void
    {
        $seller = $this->seller();
        $product = $this->product($seller, 'product-videos/edit-page.mp4');

        $this->withSession($this->sellerSession($seller))
            ->get(route('seller.product.edit', $product->id))
            ->assertOk()
            ->assertSee('Edit Product')
            ->assertSee('storage/product-videos/edit-page.mp4');
    }

    public function test_invalid_video_type_is_rejected(): void
    {
        $seller = $this->seller();
        $product = $this->product($seller);

        $this->withSession($this->sellerSession($seller))
            ->from(route('seller.product.edit', $product->id))
            ->post(route('seller.product.update', $product->id), $this->productFields([
                'video' => UploadedFile::fake()->create('not-video.txt', 5, 'text/plain'),
            ]))
            ->assertSessionHasErrors('video');
    }

    public function test_video_above_the_configured_one_hundred_megabyte_limit_is_rejected(): void
    {
        $seller = $this->seller();
        $product = $this->product($seller);

        $this->withSession($this->sellerSession($seller))
            ->from(route('seller.product.edit', $product->id))
            ->post(route('seller.product.update', $product->id), $this->productFields([
                'video' => UploadedFile::fake()->create('too-large.mp4', 102401, 'video/mp4'),
            ]))
            ->assertSessionHasErrors([
                'video' => 'Product video must not exceed 100 MB.',
            ]);
    }

    public function test_video_at_the_configured_one_hundred_megabyte_limit_is_accepted(): void
    {
        $seller = $this->seller();

        $this->withSession($this->sellerSession($seller))
            ->post(route('seller.product.store'), $this->productFields([
                'image' => $this->fakePng(),
                'video' => UploadedFile::fake()->create('maximum.mp4', 102400, 'video/mp4'),
            ]))
            ->assertRedirect('/seller-dashboard');

        $product = Product::where('seller_id', $seller->id)->firstOrFail();
        $this->assertNotEmpty($product->video);
        Storage::disk('public')->assertExists($product->video);
        $imagePath = public_path('products/' . $product->image);
        $this->assertFileExists($imagePath);
        unlink($imagePath);
    }

    public function test_seller_cannot_upload_video_to_another_sellers_product(): void
    {
        $owner = $this->seller('owner@example.com');
        $other = $this->seller('other@example.com');
        $product = $this->product($owner);

        $this->withSession($this->sellerSession($other))
            ->post(route('seller.product.update', $product->id), $this->productFields([
                'video' => UploadedFile::fake()->create('demo.mp4', 500, 'video/mp4'),
            ]))
            ->assertNotFound();

        $this->assertNull($product->fresh()->video);
        $this->assertSame([], Storage::disk('public')->allFiles('product-videos'));
    }

    private function seller(string $email = 'video-seller@example.com'): SellerProfile
    {
        return SellerProfile::create([
            'seller_name' => 'Video Seller',
            'shop_name' => 'Video Shop',
            'email' => $email,
            'mobile_number' => '9999999999',
            'password' => Hash::make('Password1!'),
        ]);
    }

    private function product(SellerProfile $seller, ?string $video = null): Product
    {
        return Product::create([
            'seller_id' => $seller->id,
            'name' => 'Test product',
            'category' => 'Test',
            'price' => 100,
            'stock' => 5,
            'image' => 'existing.jpg',
            'video' => $video,
        ]);
    }

    private function sellerSession(SellerProfile $seller): array
    {
        return ['seller_login' => true, 'seller_id' => $seller->id];
    }

    private function productFields(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Test product',
            'category' => 'Test',
            'brand' => 'Test brand',
            'price' => 100,
            'description' => 'Test description',
            'stock' => 5,
            'status' => 'active',
        ], $overrides);
    }

    private function fakePng(): UploadedFile
    {
        $contents = base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/n6sAAAAASUVORK5CYII=',
            true
        );

        return UploadedFile::fake()->createWithContent('product.png', $contents ?: '');
    }
}
