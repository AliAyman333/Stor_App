<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'sara@example.com')->first();

        if ($user) {
            Employee::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'department' => 'Sales',
                    'salary' => 3500.00,
                ]
            );
        }

        $user2 = User::where('email', 'nasser@example.com')->first();

        if ($user2) {
            Employee::firstOrCreate(
                ['user_id' => $user2->id],
                [
                    'department' => 'Support',
                    'salary' => 2800.00,
                ]
            );
        }
    }
}
