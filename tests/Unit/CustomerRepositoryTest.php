<?php

namespace Tests\Unit;

use App\Models\Tenant\Customer;
use PHPUnit\Framework\TestCase;
use App\Repositories\Tenant\CustomerRepository;
use Mockery;


class CustomerRepositoryTest extends TestCase
{
    
    public function test_can_find_customer_by_id_in_repository()
    {
        // Crear un mock para la clase Usuario, simulando la llamada a 'findOrFail()'
        $customer_mock = Mockery::mock(Customer::class);
        $customer_mock->shouldReceive('findOrFail')->with(1)->once()->andReturn($customer_mock);

        // Crear una instancia del repositorio y asignar el mock
        $customer_repository = new CustomerRepository($customer_mock);

        // Obtener el usuario por id
        $customer = $customer_repository->findById(1);

        // Asegurarse de que 'findOrFail' se llamó con los argumentos correctos
        $customer_mock->shouldHaveReceived('findOrFail')->with(1)->once();

        // Verificar que el método 'findById' devuelva la misma instancia de Customer que el mock
        $this->assertInstanceOf(Customer::class, $customer);

        // Verificar que el resultado sea el mismo que el mock
        $this->assertSame($customer_mock, $customer);

    }

    protected function tearDown(): void
    {
        Mockery::close(); // Importante cerrar los mocks para evitar problemas
    }

}
