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

    public function getStoreHeartItems()
    {
        $items = $this->storeItemRepository->getStoreHeartItems();
        if ($items->isEmpty()) {
            throw new AppException('Không có vật phẩm nào trong cửa hàng.');
        }
        
        return $items;
    }

    public function getStoreMascotItems(string $userId)
    {
        if (!$userId) {
            throw new AppException('Người dùng không hợp lệ hoặc không tồn tại!');
        }

        $itemsStatus = $this->storeItemRepository->getStoreMascotItems($userId);

        return $itemsStatus;
    }
}
