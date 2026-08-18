<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Seeder;

class ActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'ahmed@example.com')->first();

        ActivityLog::create([
            'user_id' => $user?->id,
            'action' => 'login',
            'description' => 'User logged in successfully',
            'ip_address' => '192.168.1.10',
        ]);

        ActivityLog::create([
            'user_id' => $user?->id,
            'action' => 'created_product',
            'description' => 'Admin added a new product',
            'ip_address' => '192.168.1.15',
        ]);

        $user2 = User::where('email', 'sara@example.com')->first();

        ActivityLog::create([
            'user_id' => $user2?->id,
            'action' => 'viewed_profile',
            'description' => 'Employee viewed profile details',
            'ip_address' => '192.168.1.20',
        ]);
    }
}
