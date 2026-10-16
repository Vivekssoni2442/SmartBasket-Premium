<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerAiLauncherTest extends TestCase
{
    use RefreshDatabase;

    public function test_shared_customer_layout_mounts_one_smart_ai_launcher(): void
    {
        $customer = User::factory()->create();

        $response = $this->actingAs($customer)
            ->get(route('addresses.index'))
            ->assertOk()
            ->assertSee('data-smart-ai-open')
            ->assertSee('data-smart-ai-panel')
            ->assertSee(route('customer-ai.message'));

        $this->assertSame(1, substr_count($response->getContent(), 'class="smart-ai"'));
    }

    public function test_product_listing_retains_one_robot_instance_and_taskbar_button(): void
    {
        $customer = User::factory()->create();

        $response = $this->actingAs($customer)
            ->get(route('products.index'))
            ->assertOk()
            ->assertSee('id="sbProductsSmartAI"', false)
            ->assertSee('data-smart-ai-open');

        $this->assertSame(1, substr_count($response->getContent(), 'class="smart-ai"'));
    }
}
