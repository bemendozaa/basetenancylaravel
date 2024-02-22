<?php

namespace App\Services\Tenant;

use App\Repositories\Tenant\ItemRepositoryInterface;


class ItemService
{

    protected $itemRepository;
    
    
    public function __construct(ItemRepositoryInterface $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    
    public function getRecord($id)
    {
        return $this->itemRepository->findById($id);
    }


    public function getRecords()
    {
        return $this->itemRepository->records();
    }


    public function storeOrUpdateRecord($data)
    {
        return $this->itemRepository->storeOrUpdate($data);
    }


    public function destroyRecordById($id)
    {
        $this->itemRepository->destroyById($id);
    }

}