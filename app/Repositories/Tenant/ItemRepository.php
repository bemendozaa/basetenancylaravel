<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant\Item;
use App\Repositories\Tenant\Contracts\ItemRepositoryInterface;

class ItemRepository extends SimpleCrudRepository implements ItemRepositoryInterface
{

    protected $model;

    public function __construct(Item $model)
    {
        $this->model = $model;
    }
    

    public function columns(): array
    {
        return [
            "item"
        ];
    }

}