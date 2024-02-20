<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant\Customer;
use Illuminate\Pagination\LengthAwarePaginator;

interface CustomerRepositoryInterface
{
    public function records() : LengthAwarePaginator;
    public function findById($id) : Customer;
    public function storeOrUpdate($data) : Customer;
    public function destroyById($id);
}