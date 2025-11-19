<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_to_cart(): void
    {
        // Arrange: create a user and a product
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 1000]);

        // Act: simulate adding product to cart
        $response = $this->actingAs($user)
            ->postJson(route('cart.add'), [
                'product_id' => $product->id,
                'quantity'   => 2,
            ]);

        // Assert: response is OK and contains success flag
        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                 ]);

        // Extra: assert cart item exists in DB
        $this->assertDatabaseHas('cart_items', [
            'product_id' => $product->id,
            'quantity'   => 2,
            'unit_price' => 1000,
            'line_total' => 2000,
        ]);
    }
}