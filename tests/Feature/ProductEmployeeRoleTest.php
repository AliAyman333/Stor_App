<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductEmployeeRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_employee_cannot_create_product(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/insert', [
                'name' => 'New Product',
                'description' => 'Test description',
                'price' => 99.99,
                'stock' => 10,
            ])
            ->assertStatus(403);
    }

    public function test_employee_can_create_product(): void
    {
        $user = User::factory()->create();
        Employee::create([
            'user_id' => $user->id,
            'department' => 'Sales',
            'salary' => 3000,
        ]);

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/insert', [
                'name' => 'Employee Product',
                'description' => 'Allowed product',
                'price' => 49.50,
                'stock' => 5,
            ])
            ->assertStatus(201)
            ->assertJsonPath('product.name', 'Employee Product');

        $this->assertDatabaseHas('products', ['name' => 'Employee Product']);
    }
}
