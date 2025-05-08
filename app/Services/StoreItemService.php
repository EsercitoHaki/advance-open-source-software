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
        $items = $this->storeItemRepository->getItemsWithPurchaseStatus($userId);

        if (is_null($items)) {
            throw new AppException('Không thể lấy danh sách item từ cửa hàng.');
        }

        if ($items->isEmpty()) {
            throw new AppException('Hiện tại không có item nào trong cửa hàng.');
        }

        return $items;
    }

    public function getStoreItemsWithPurchaseStatus(string $userId)
    {
        if (!$userId) {
            throw new AppException('Thiếu user_id.');
        }

        $itemsStatus = $this->storeItemRepository->getItemsWithPurchaseStatus($userId);

        return $itemsStatus;
    }
}
