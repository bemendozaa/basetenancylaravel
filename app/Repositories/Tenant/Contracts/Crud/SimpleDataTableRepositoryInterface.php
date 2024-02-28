<?php

namespace App\Repositories\Tenant\Contracts\Crud;

use Illuminate\Pagination\LengthAwarePaginator;


interface SimpleDataTableRepositoryInterface
{
    public function getPaginateRecords() : LengthAwarePaginator;
}