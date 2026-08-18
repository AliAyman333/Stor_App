<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderRelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_and_product_can_have_order(): void
    {
        $user = User::factory()->create();
        $product = Product::create([
            'name' => 'Mouse',
            'description' => 'Wireless mouse',
            'price' => 150.00,
            'stock' => 20,
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'total_price' => 300.00,
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'status' => 'pending',
        ]);

        $this->assertEquals($user->id, $order->user->id);
        $this->assertEquals($product->id, $order->product->id);
    }
}
