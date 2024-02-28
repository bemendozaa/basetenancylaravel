<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\CustomerRequest;
use App\Http\Resources\Tenant\CustomerCollection;
use App\Http\Resources\Tenant\CustomerResource;
use App\Repositories\Tenant\CustomerRepositoryInterface;
use App\Services\Tenant\CustomerService;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;


class CustomerController extends Controller
{

    protected $customerService;
    
    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }


    public function index()
    {
        return Inertia::render('Tenant/Customers/Index');
    }


    public function record($id)
    {
        return new CustomerResource($this->customerService->getRecord($id));
    }


    public function records(Request $request)
    {
        return new CustomerCollection($this->customerService->getRecords($request->column, $request->value));
    }


    public function store(CustomerRequest $request)
    {
        try 
        {
            $this->customerService->storeOrUpdateRecord($request->all());

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
            $this->customerService->destroyRecordById($id);

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

    
    public function columns()
    {
        return $this->customerService->getSearchColumns();
    }

}
