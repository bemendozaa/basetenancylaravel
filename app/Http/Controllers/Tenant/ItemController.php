<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\ItemRequest;
use App\Http\Resources\Tenant\ItemCollection;
use App\Http\Resources\Tenant\ItemResource;
use App\Models\Tenant\Item;
use Exception;


class ItemController extends Controller
{
    
    public function record($id)
    {
        return new ItemResource(Item::findOrFail($id));
    }


    public function records()
    {
        return new ItemCollection(Item::latest()->paginate(config('tenant.items_per_page')));
    }


    public function store(ItemRequest $request)
    {
        try 
        {
            $id = $request->id;
            $record = Item::firstOrNew(['id' => $id]);
            $record->fill($request->all());
            $record->save();

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
            $record = Item::findOrFail($id);
            $record->delete();

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
