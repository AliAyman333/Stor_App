<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::firstOrCreate(
            ['name' => 'Laptop'],
            [
                'description' => 'Laptop for office work',
                'price' => 2500.00,
                'stock' => 10,
            ]
        );

        Product::firstOrCreate(
            ['name' => 'Phone'],
            [
                'description' => 'Smartphone with dual camera',
                'price' => 1800.00,
                'stock' => 15,
            ]
        );

        Product::firstOrCreate(
            ['name' => 'Headphones'],
            [
                'description' => 'Wireless headphones',
                'price' => 300.00,
                'stock' => 20,
            ]
        );
    }
}
