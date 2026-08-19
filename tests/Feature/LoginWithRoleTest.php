<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginWithRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_an_assigned_role(): void
    {
        $user = User::factory()->create();
        Customer::create(['user_id' => $user->id]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
            'role' => 'customer',
        ]);

        $response->assertOk()
            ->assertJsonPath('role', 'customer')
            ->assertJsonStructure(['token', 'user', 'role']);
    }

    public function test_user_cannot_login_with_an_unassigned_role(): void
    {
        $user = User::factory()->create();
        Customer::create(['user_id' => $user->id]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
            'role' => 'admin',
        ]);

        $response->assertForbidden()
            ->assertJson([
                'message' => 'The selected role is not assigned to this user',
            ]);
        $this->assertGuest();
    }
}