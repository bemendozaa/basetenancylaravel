<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant\Customer;
use App\Repositories\Tenant\Contracts\CustomerRepositoryInterface;

class CustomerRepository extends CrudRepository implements CustomerRepositoryInterface
{

    protected $model;

    public function __construct(Customer $model)
    {
        $this->model = $model;
    }


}