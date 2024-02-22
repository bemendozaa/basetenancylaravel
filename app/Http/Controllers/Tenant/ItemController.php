<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\ItemRequest;
use App\Http\Resources\Tenant\ItemCollection;
use App\Http\Resources\Tenant\ItemResource;
use App\Models\Tenant\Item;
use App\Services\Tenant\ItemService;
use Exception;


class ItemController extends Controller
{

    public $itemService;

    public function __construct(ItemService $itemService) 
    {
        $this->itemService = $itemService;
    }


    public function record($id)
    {
        return new ItemResource($this->itemService->getRecord($id));
    }


    public function records()
    {
        return new ItemCollection($this->itemService->getRecords());
    }


    public function store(ItemRequest $request)
    {
        try 
        {
            $id = $request->id;
            $this->itemService->storeOrUpdateRecord($request->all());

            return [
                'success' => true,
                'message' => $id ? 'Producto actualizado correctamente.' : 'Producto creado correctamente.',
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
            $this->itemService->destroyRecordById($id);

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
