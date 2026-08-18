<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_have_admin_profile(): void
    {
        $user = User::factory()->create();

        $admin = Admin::create([
            'user_id' => $user->id,
            'phone' => '0500000000',
            'position' => 'Manager',
        ]);

        $this->assertDatabaseHas('admins', [
            'user_id' => $user->id,
            'position' => 'Manager',
        ]);

        $this->assertEquals($user->id, $admin->user->id);
        $this->assertNotNull($user->admin);
    }
}
