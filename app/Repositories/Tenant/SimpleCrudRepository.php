<?php

namespace App\Repositories\Tenant;

use App\Models\BaseModel;
use App\Repositories\Tenant\Contracts\Crud\SimpleCrudRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;


abstract class SimpleCrudRepository implements SimpleCrudRepositoryInterface
{

    protected $model;

    public function __construct(BaseModel $model)
    {
        $this->model = $model;
    }

    
    public function getPaginateRecords() : LengthAwarePaginator
    {   
        return $this->model->latest()->paginate(config('tenant.items_per_page'));
    }


    public function findById($id) : BaseModel
    {
        return $this->model->findOrFail($id);
    }


    public function storeOrUpdate($data = []) : BaseModel
    {   
        $id = $data['id'] ?? null;
        $record = $this->model->firstOrNew(['id' => $id]);
        $record->fill($data);
        $record->save();

        return $record;
    }
    

    public function destroyById($id)
    {
        return $this->findById($id)->delete();
    }


}
