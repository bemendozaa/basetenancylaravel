<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant\Item;
use Illuminate\Pagination\LengthAwarePaginator;

class ItemRepository implements ItemRepositoryInterface
{

    public function records() : LengthAwarePaginator
    {   
        return Item::latest()->paginate(config('tenant.items_per_page'));
    }

    public function findById($id) : Item
    {
        return Item::findOrFail($id);
    }

    public function storeOrUpdate($data = []) : Item
    {   
        $id = $data['id'] ?? null;
        $record = Item::firstOrNew(['id' => $id]);
        $record->fill($data);
        $record->save();

        return $record;
    }
    
    public function destroyById($id)
    {
        return $this->findById($id)->delete();
    }

}