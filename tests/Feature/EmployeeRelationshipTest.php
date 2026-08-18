<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeRelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_have_employee_profile(): void
    {
        $user = User::factory()->create();

        $employee = Employee::create([
            'user_id' => $user->id,
            'department' => 'Sales',
            'salary' => 3000.50,
        ]);

        $this->assertDatabaseHas('employees', [
            'user_id' => $user->id,
            'department' => 'Sales',
        ]);

        $this->assertEquals($user->id, $employee->user->id);
        $this->assertNotNull($user->employee);
    }
}
