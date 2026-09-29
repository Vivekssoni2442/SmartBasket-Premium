<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_page_shows_only_seller_uploaded_products(): void
    {
        $imageDirectory = public_path('products');

        if (!is_dir($imageDirectory)) {
            mkdir($imageDirectory, 0755, true);
        }

        file_put_contents($imageDirectory . '/laptop.jpg', 'test');

        Product::create([
            'name' => 'Seller Laptop',
            'category' => 'Electronics',
            'description' => 'Added by seller',
            'image' => 'laptop.jpg',
            'price' => 89999,
            'rating' => 4.8,
            'stock' => 10,
        ]);

        Product::create([
            'name' => 'Seeded Dummy Product',
            'category' => 'Electronics',
            'description' => 'Should not appear',
            'image' => 'https://images.unsplash.com/photo-123',
            'price' => 100,
            'rating' => 3.5,
            'stock' => 5,
        ]);

        $response = $this->get('/products');

        $response->assertStatus(200);
        $response->assertSee('Seller Laptop');
        $response->assertDontSee('Seeded Dummy Product');
    }
}
