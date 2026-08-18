<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'ahmed@example.com')->first();

        if ($user) {
            Customer::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'address' => 'Riyadh - Al Malqa',
                    'phone' => '0551112233',
                ]
            );
        }

        $user2 = User::where('email', 'sara@example.com')->first();

        if ($user2) {
            Customer::firstOrCreate(
                ['user_id' => $user2->id],
                [
                    'address' => 'Jeddah - Al Hamra',
                    'phone' => '0554445566',
                ]
            );
        }
    }
}
