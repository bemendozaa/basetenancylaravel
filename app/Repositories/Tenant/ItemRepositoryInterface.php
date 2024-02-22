<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant\Item;
use Illuminate\Pagination\LengthAwarePaginator;

interface ItemRepositoryInterface
{
    public function records() : LengthAwarePaginator;
    public function findById($id) : Item;
    public function storeOrUpdate($data) : Item;
    public function destroyById($id);
}