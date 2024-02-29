<?php

namespace Tests\Feature;

use App\Models\Tenant\User;
use Tests\RefreshDatabaseWithTenant;
use Tests\TestCase;


class TenantExampleTest extends TestCase
{

    use RefreshDatabaseWithTenant;
    

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
