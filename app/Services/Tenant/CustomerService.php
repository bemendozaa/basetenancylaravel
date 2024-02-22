<?php

namespace App\Services\Tenant;

use App\Repositories\Tenant\CustomerRepositoryInterface;


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


    public function getRecords()
    {
        return $this->customerRepository->records();
    }


    public function storeOrUpdateRecord($data)
    {
        return $this->customerRepository->storeOrUpdate($data);
    }


    public function destroyRecordById($id)
    {
        $this->customerRepository->destroyById($id);
    }

}