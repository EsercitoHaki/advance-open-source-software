<?php

namespace App\Services;

use App\Repositories\StoreItemRepository;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\AppException;
use App\Services\Interfaces\StoreItemServiceInterface;
use App\DTOs\StoreItemDTO;
use App\Models\StoreItem;
use App\Models\User;

class StoreItemService implements StoreItemServiceInterface
{
    protected $storeItemRepository;

    public function __construct(StoreItemRepository $storeItemRepository)
    {
        $this->storeItemRepository = $storeItemRepository;
    }

    public function getStoreHeartItems(): array
    {
        $items = $this->storeItemRepository->getStoreHeartItems();
        if ($items->isEmpty()) {
            throw new AppException('Không có vật phẩm nào trong cửa hàng.');
        }
        
        return $items->map(fn($storeitem) => StoreItemDTO::fromModel($storeitem))->toArray();
    }

    public function getStoreMascotItems(string $userId): array
    {
        if (!$userId) {
            throw new AppException('Người dùng không hợp lệ hoặc không tồn tại!');
        }

        $items = $this->storeItemRepository->getStoreMascotItems($userId);
        if ($items->isEmpty()) {
            throw new AppException('Không có vật phẩm nào trong cửa hàng.');
        }
        return $items->map(fn($storeitem) => StoreItemDTO::fromModel($storeitem))->toArray();
    }

    public function getMascots(string $userId): array
    {
        if (!$userId) {
            throw new AppException('Người dùng không hợp lệ hoặc không tồn tại!');
        }

        $mascots = $this->storeItemRepository->getMascots($userId); 

        return $mascots->map(fn($mascot) => [
            'item_id' => $mascot->item_id,
            'item_name' => $mascot->item_name,
        ])->toArray();
    }
}
