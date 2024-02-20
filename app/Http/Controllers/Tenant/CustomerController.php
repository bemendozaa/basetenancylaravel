<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\CustomerRequest;
use App\Http\Resources\Tenant\CustomerCollection;
use App\Http\Resources\Tenant\CustomerResource;
use App\Repositories\Tenant\CustomerRepositoryInterface;
use Exception;
use Inertia\Inertia;


class CustomerController extends Controller
{

    protected $customerRepository;
    
    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }


    public function index()
    {
        return Inertia::render('Tenant/Customers/Index');
    }


    public function record($id)
    {
        return new CustomerResource($this->customerRepository->findById($id));
    }


    public function records()
    {
        return new CustomerCollection($this->customerRepository->records());
    }


    public function store(CustomerRequest $request)
    {
        try 
        {
            $this->customerRepository->storeOrUpdate($request->validated());

            return [
                'success' => true,
                'message' => $request->id ? 'Producto actualizado correctamente.' : 'Producto creado correctamente.',
            ];

        }
        catch(Exception $e) 
        {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

    }
    
    
    public function delete($id)
    {
        try 
        {
            $this->customerRepository->destroyById($id);

            return [
                'success' => true,
                'message' => 'Producto eliminado',
            ];
        }
        catch(Exception $e) 
        {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

}
