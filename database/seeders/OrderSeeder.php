<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'ahmed@example.com')->first();
        $product = Product::where('name', 'Laptop')->first();

        if ($user && $product) {
            Order::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'total_price' => $product->price,
                'status' => 'pending',
            ]);
        }

        $user2 = User::where('email', 'sara@example.com')->first();
        $product2 = Product::where('name', 'Phone')->first();

        if ($user2 && $product2) {
            Order::create([
                'user_id' => $user2->id,
                'product_id' => $product2->id,
                'quantity' => 2,
                'total_price' => $product2->price * 2,
                'status' => 'completed',
            ]);
        }
    }
}
