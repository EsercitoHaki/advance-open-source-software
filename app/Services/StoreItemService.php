<?php

namespace App\Services;

use App\Repositories\StoreItemRepository;

class StoreItemService
{
    protected $storeItemRepository;

    public function __construct(StoreItemRepository $storeItemRepository)
    {
        $this->storeItemRepository = $storeItemRepository;
    }

    public function getAllItems()
    {
        return $this->storeItemRepository->getAllItems();
    }
    

    public function getStoreItemsWithPurchaseStatus(string $userId)
    {
        $items = $this->storeItemRepository->getItemsWithPurchaseStatus($userId);

        return $items;
    }
}
