<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WishlistAndRecentlyViewedTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_wishlist_and_view_recently_viewed_products(): void
    {
        $user = User::factory()->create();
        $product = Product::create([
            'name' => 'Noise Cancelling Earbuds',
            'category' => 'Audio',
            'description' => 'Immersive sound',
            'image' => 'earbuds.jpg',
            'price' => 499.00,
            'rating' => 4.7,
            'stock' => 15,
        ]);

        $this->actingAs($user);

        $response = $this->post('/wishlist/add/' . $product->id);
        $response->assertRedirect();
        $this->assertDatabaseHas('wishlists', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $showResponse = $this->get('/products/' . $product->id);
        $showResponse->assertOk();
        $this->assertDatabaseHas('recently_viewed_products', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }
}
