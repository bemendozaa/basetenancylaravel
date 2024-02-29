<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Central\User;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    
    public function test_create_user_in_central_bd(): void
    {
        $user = User::factory()->create();

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
        ];

        $this->assertDatabaseHas('users', $data);
    }


    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
