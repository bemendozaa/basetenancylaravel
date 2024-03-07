<?php

namespace Tests\Unit\Customer;

use App\Models\Tenant\Customer;
use PHPUnit\Framework\TestCase;
use App\Repositories\Tenant\CustomerRepository;
use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Config;
use Mockery;


class CustomerRepositoryTest extends TestCase
{
    protected $customer_mock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->customer_mock = Mockery::mock(Customer::class);
    }


    public function test_can_find_customer_by_id_in_repository()
    {
        // Crear un mock para la clase Usuario, simulando la llamada a 'findOrFail()'
        $this->customer_mock->shouldReceive('findOrFail')->with(1)->once()->andReturn($this->customer_mock);

        // Crear una instancia del repositorio y asignar el mock
        $customer_repository = new CustomerRepository($this->customer_mock);

        // Obtener el usuario por id
        $customer = $customer_repository->findById(1);

        // Asegurarse de que 'findOrFail' se llamó con los argumentos correctos
        $this->customer_mock->shouldHaveReceived('findOrFail')->with(1)->once();

        // Verificar que el método 'findById' devuelva la misma instancia de Customer que el mock
        $this->assertInstanceOf(Customer::class, $customer);

        // Verificar que el resultado sea el mismo que el mock
        $this->assertSame($this->customer_mock, $customer);

    }

    
    public function test_can_get_paginated_customers_successfully(): void
    {
        $customer_repository = new CustomerRepository($this->customer_mock);

        // el método andReturnSelf() se utiliza para indicar que el mock debe devolver la instancia actual 
        // del objeto sobre el cual se está llamando el método. Es decir, cuando el método mockeado es llamado, 
        // en lugar de devolver un valor específico, simplemente devuelve el propio objeto mock.

        $this->customer_mock->shouldReceive('query')->andReturnSelf(); // Simular el método query()
        $this->customer_mock->shouldReceive('where')->andReturnSelf(); // Simular el método where()
        $this->customer_mock->shouldReceive('latest')->andReturnSelf(); // Simular el método latest()
        $this->customer_mock->shouldReceive('paginate')->andReturn($this->getFakePaginator());


        // Llamar al método que utiliza getPaginateRecords en el repositorio
        $result = $customer_repository->getPaginateRecords('name', 'valor', 10);

        // Realizar aserciones sobre el resultado, según sea necesario
        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }
    

    protected function getFakePaginator()
    {
        //  devolver un objeto LengthAwarePaginator falso para las pruebas
        return new LengthAwarePaginator([], 0, 10);
    }


    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close(); // Importante cerrar los mocks para evitar problemas
    }

}
