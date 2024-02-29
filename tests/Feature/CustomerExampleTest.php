<?php

namespace Tests\Feature;

use App\Models\Tenant\Customer;
use App\Models\Tenant\User;
use Tests\RefreshDatabaseWithTenant;
use Tests\TestCase;


class CustomerExampleTest extends TestCase
{

    use RefreshDatabaseWithTenant;
    
    public function test_create_customer_in_bd(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $data = [
            'name' => 'empresa',
            'number' => 12345678,
        ];

        $response = $this->post('/customers', $data);


        $response->assertOk()
                ->assertJson([
                    'success' => true,
                    'message' => 'Cliente creado correctamente.',
                ]);
    }

    
    public function test_get_customers_in_bd(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/customers');

        $response->assertOk();
    }

    
    public function test_get_customer_by_id_in_bd(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        
        $data = [
            'name' => 'empresa',
            'number' => 12345678,
        ];

        $customer = Customer::create($data);

        $response = $this->get("/customers/record/{$customer->id}");

        $response->assertOk()
                ->assertJson([
                    'data' => [
                        'id' => $customer->id
                    ],
                ]);
    }

}
