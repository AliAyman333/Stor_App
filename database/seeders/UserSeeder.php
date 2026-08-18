<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Ahmed Ali',
            'email' => 'ahmed@example.com',
        ]);

        User::factory()->create([
            'name' => 'Sara Mohamed',
            'email' => 'sara@example.com',
        ]);

        User::factory()->create([
            'name' => 'Nasser Salem',
            'email' => 'nasser@example.com',
        ]);
    }
}
