<?php

namespace App\Services;

use App\Repositories\StoreItemRepository;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\AppException;

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
        if (!$userId) {
            throw new AppException('Người dùng không hợp lệ.');
        }

        $itemsStatus = $this->storeItemRepository->getItemsWithPurchaseStatus($userId);

        return $itemsStatus;
    }
}
