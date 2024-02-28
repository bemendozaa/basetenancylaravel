<?php

namespace App\Repositories\Tenant\Contracts\Crud;

use Illuminate\Pagination\LengthAwarePaginator;


interface DataTableRepositoryInterface
{
    public function getPaginateRecords(string $column, ?string $value) : LengthAwarePaginator;
    public function getSearchColumns() : array;
}