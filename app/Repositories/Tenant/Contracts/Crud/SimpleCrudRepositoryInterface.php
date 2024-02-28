<?php

namespace App\Repositories\Tenant\Contracts\Crud;

use App\Models\BaseModel;


interface SimpleCrudRepositoryInterface extends SimpleDataTableRepositoryInterface
{
    public function findById($id) : BaseModel;
    public function storeOrUpdate($data) : BaseModel;
    public function destroyById($id);
}