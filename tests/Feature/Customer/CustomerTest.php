<?php

namespace Tests\Feature\Customer;

use App\Models\Tenant\Customer;
use App\Models\Tenant\User;
use App\Services\Tenant\CustomerService;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\ExistingTestDatabaseTenant;
use Tests\RefreshDatabaseWithTenant;
use Tests\TestCase;
use Tests\Traits\MainTestTrait;

class CustomerTest extends TestCase
{

    use ExistingTestDatabaseTenant, MainTestTrait;

    protected $customerService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->initializeTenant();
        $this->loginUser();

        $this->customerService = app(CustomerService::class);
    }
    
    
    public function test_can_get_paginated_customers_successfully(): void
    {
        $this->createFactoryRecord(Customer::class, 5);

        $response = $this->get('/customers/records?column=name');
        
        $response->assertOk();

        $responseData = json_decode($response->getContent(), true);

        // Verificar que la estructura de la respuesta es la esperada
        $this->assertArrayHasKey('data', $responseData);
        $this->assertArrayHasKey('links', $responseData);
        $this->assertArrayHasKey('meta', $responseData);
        $this->assertNotEmpty($responseData['data']);
    }

    
    public function test_can_find_customer_by_id_not_found(): void
    {
        $response = $this->get("/customers/record/-1");

        $response->assertNotFound();
    }


    public function test_can_find_customer_by_id_successfully(): void
    {
        $customer = $this->createFactoryRecord(Customer::class);

        $response = $this->get("/customers/record/{$customer->id}");

        $response->assertOk()
                ->assertJson([
                    'data' => [
                        'id' => $customer->id
                    ],
                ]);
    }

    
    public function test_register_customer_with_correct_data_successfully(): void
    {
        $data = [
            'name' => 'Cliente',
            'number' => 12345678,
        ];

        $response = $this->postJson('/customers', $data);

        $response->assertOk()
                ->assertJson([
                    'success' => true,
                    'message' => 'Cliente creado correctamente.',
                ]);
    }
    
    
    public function test_register_customer_with_repository_successfully(): void
    {
        $data = [
            'name' => 'juan z',
            'number' => 22345678,
        ];

        $customer = $this->customerService->storeOrUpdateRecord($data);

        // Verificar que el cliente se haya creado correctamente
        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertDatabaseHas('customers', $data);
    
    }

    
    public function test_register_customer_with_unprocessable_data_error(): void
    {
        $data = [
            'name' => null,
            'number' => 1,
        ];
        
        $response = $this->postJson('/customers', $data);

        $response->assertUnprocessable();
        
        $responseData = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('message', $responseData);
        $this->assertArrayHasKey('errors', $responseData);

    }

    
    public function test_update_customer_with_correct_data_successfully(): void
    {
        $customer = $this->createFactoryRecord(Customer::class);

        $data = $customer->toArray();
        $data['name'] = 'customer_updated';

        $response = $this->postJson('/customers', $data);

        $response->assertOk()
                ->assertJson([
                    'success' => true,
                    'message' => 'Cliente actualizado correctamente.',
                ]);
    }
    

    public function test_can_delete_customer_successfully(): void
    {
        $data = [
            'name' => 'juan z',
            'number' => 22345678,
        ];

        $customer = $this->customerService->storeOrUpdateRecord($data);

        $response = $this->delete("/customers/{$customer->id}");

        $response->assertJson([
            'success' => true,
            'message' => 'Cliente eliminado',
        ]);

        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
    }


    private function createFactoryRecord(string $model, int $quantity = null)
    {
        return $model::factory($quantity)->create();
    }

}
