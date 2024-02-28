<?php

namespace App\Repositories\Tenant;

use App\Models\BaseModel;
use App\Repositories\Tenant\Contracts\Crud\CrudRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;


abstract class CrudRepository implements CrudRepositoryInterface
{

    protected $model;

    public function __construct(BaseModel $model)
    {
        $this->model = $model;
    }

    
    public function getPaginateRecords(string $column, ?string $value) : LengthAwarePaginator
    {   
        $query = $this->model->query();

        if(!empty($value))
        {
            $query->where($column, 'like', "%{$value}%");
        }


        return $query->latest()->paginate(config('tenant.items_per_page'));
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
    

    public function getSearchColumns(): array
    {
        return $this->model->getSearchColumns();
    }

}
