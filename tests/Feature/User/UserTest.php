<?php

namespace Tests\Feature\User;

use App\Models\Tenant\User;
use Tests\ExistingTestDatabaseTenant;
use Tests\RefreshDatabaseWithTenant;
use Tests\TestCase;


class UserTest extends TestCase
{

    use ExistingTestDatabaseTenant;
    

    protected function setUp(): void
    {
        parent::setUp();

        $this->initializeTenant();
    }

    
    public function test_create_user_in_bd(): void
    {
        $user = User::factory()->create();

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
        ];

        $this->assertDatabaseHas('users', $data);
    }


}
