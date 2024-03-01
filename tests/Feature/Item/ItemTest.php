<?php

namespace Tests\Feature\Item;

use App\Models\Tenant\Item;
use App\Services\Tenant\ItemService;
use Tests\ExistingTestDatabaseTenant;
use Tests\TestCase;
use Tests\Traits\MainTestTrait;


class ItemTest extends TestCase
{

    use ExistingTestDatabaseTenant, MainTestTrait;

    protected $itemService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->initializeTenant();
        $this->loginUser();

        $this->itemService = app(ItemService::class);
    }
    
    
    public function test_can_get_paginated_items_successfully(): void
    {
        $this->createFactoryRecord(Item::class, 5);

        $response = $this->get('/items/records?column=name');
        
        $response->assertOk();

        $responseData = json_decode($response->getContent(), true);

        // Verificar que la estructura de la respuesta es la esperada
        $this->assertArrayHasKey('data', $responseData);
        $this->assertArrayHasKey('links', $responseData);
        $this->assertArrayHasKey('meta', $responseData);
        $this->assertNotEmpty($responseData['data']);
    }

    
    public function test_can_find_item_by_id_not_found(): void
    {
        $response = $this->get("/items/record/-1");

        $response->assertNotFound();
    }


    public function test_can_find_item_by_id_successfully(): void
    {
        $item = $this->createFactoryRecord(Item::class);

        $response = $this->get("/items/record/{$item->id}");

        $response->assertOk()
                ->assertJson([
                    'data' => [
                        'id' => $item->id
                    ],
                ]);
    }

    
    public function test_register_item_with_correct_data_successfully(): void
    {
        $data = [
            'name' => 'producto',
            'price' => 10,
        ];

        $response = $this->postJson('/items', $data);

        $response->assertOk()
                ->assertJson([
                    'success' => true,
                    'message' => 'Producto creado correctamente.',
                ]);
    }
    
    
    public function test_register_item_with_repository_successfully(): void
    {
        $data = [
            'name' => 'producto 1',
            'price' => 20,
        ];

        $item = $this->itemService->storeOrUpdateRecord($data);
 
        $this->assertInstanceOf(Item::class, $item);
        $this->assertDatabaseHas('items', $data);
    
    }

    
    public function test_register_item_with_unprocessable_data_error(): void
    {
        $data = [
            'name' => null,
            'price' => "20",
        ];
        
        $response = $this->postJson('/items', $data);

        $response->assertUnprocessable();
        
        $responseData = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('message', $responseData);
        $this->assertArrayHasKey('errors', $responseData);

    }

    
    public function test_update_item_with_correct_data_successfully(): void
    {
        $item = $this->createFactoryRecord(Item::class);

        $data = $item->toArray();
        $data['name'] = 'item_updated';

        $response = $this->postJson('/items', $data);

        $response->assertOk()
                ->assertJson([
                    'success' => true,
                    'message' => 'Producto actualizado correctamente.',
                ]);
    }
    

    public function test_can_delete_item_successfully(): void
    {
        $data = [
            'name' => 'producto 31',
            'price' => 20,
        ];

        $item = $this->itemService->storeOrUpdateRecord($data);

        $response = $this->delete("/items/{$item->id}");

        $response->assertJson([
            'success' => true,
            'message' => 'Producto eliminado',
        ]);

        $this->assertDatabaseMissing('items', ['id' => $item->id]);
    }


    private function createFactoryRecord(string $model, int $quantity = null)
    {
        return $model::factory($quantity)->create();
    }

}
