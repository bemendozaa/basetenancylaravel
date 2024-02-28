<?php

namespace App\Services\Tenant;

use App\Repositories\Tenant\Contracts\CustomerRepositoryInterface;

class CustomerService
{

    protected $customerRepository;
    
    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    
    public function getRecord($id)
    {
        return $this->customerRepository->findById($id);
    }


    public function getRecords(string $column, ?string $value)
    {
        return $this->customerRepository->getPaginateRecords($column, $value);
    }


    public function storeOrUpdateRecord($data)
    {
        return $this->customerRepository->storeOrUpdate($data);
    }


    public function destroyRecordById($id)
    {
        $this->customerRepository->destroyById($id);
    }
    

    public function getSearchColumns()
    {
        return $this->customerRepository->getSearchColumns();
    }

}