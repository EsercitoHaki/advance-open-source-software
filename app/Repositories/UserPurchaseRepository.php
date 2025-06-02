<?php

namespace App\Repositories;

use App\Models\UserPurchase;
use App\DTOs\UserPurchaseDTO;
use Illuminate\Support\Collection;
use App\Repositories\Interfaces\UserPurchaseRepositoryInterface;

class UserPurchaseRepository implements UserPurchaseRepositoryInterface
{
    public function createPurchase(array $data): UserPurchase
    {
        return UserPurchase::create($data);
    }

    public function getPurchasesByUserId(string $userId): Collection
    {
        return UserPurchase::where('user_id', $userId)->get();
    }

    public function hasPurchasedItem(string $userId, int $itemId): bool
    {
        return UserPurchase::where('user_id', $userId)
            ->where('item_id', $itemId)
            ->exists();
    }

    public function findByUserIdAndItemId(string $userId, int $itemId): ?UserPurchase
    {
        return UserPurchase::where('user_id', $userId)
            ->where('item_id', $itemId)
            ->first();
    }

    public function updateActiveStatus(int $purchaseId, int $active): void
    {
        UserPurchase::where('purchase_id', $purchaseId)
            ->update(['active' => $active]);
    }
}
