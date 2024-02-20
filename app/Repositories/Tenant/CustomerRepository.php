<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant\Customer;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerRepository implements CustomerRepositoryInterface
{

    public function records() : LengthAwarePaginator
    {   
        return Customer::latest()->paginate(config('tenant.items_per_page'));
    }

    public function findById($id) : Customer
    {
        return Customer::findOrFail($id);
    }

    public function storeOrUpdate($data = []) : Customer
    {   
        $id = $data['id'] ?? null;
        $record = Customer::firstOrNew(['id' => $id]);
        $record->fill($data);
        $record->save();

        return $record;
    }
    
    public function destroyById($id)
    {
        return $this->findById($id)->delete();
    }

}