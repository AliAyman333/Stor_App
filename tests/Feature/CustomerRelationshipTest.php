<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerRelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_have_customer_profile(): void
    {
        $user = User::factory()->create();

        $customer = Customer::create([
            'user_id' => $user->id,
            'address' => 'Riyadh',
            'phone' => '0551234567',
        ]);

        $this->assertDatabaseHas('customers', [
            'user_id' => $user->id,
            'address' => 'Riyadh',
        ]);

        $this->assertEquals($user->id, $customer->user->id);
        $this->assertNotNull($user->customer);
    }
}
