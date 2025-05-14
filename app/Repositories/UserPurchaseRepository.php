<?php

namespace App\Repositories;

use App\Models\UserPurchase;
use App\DTOs\UserPurchaseDTO;
use Illuminate\Support\Collection;
use App\Repositories\UserPurchaseRepositoryInterface;

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
}
