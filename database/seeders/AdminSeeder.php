<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'ahmed@example.com')->first();

        if ($user) {
            Admin::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'phone' => '0501234567',
                    'position' => 'Manager',
                ]
            );
        }
    }
}
