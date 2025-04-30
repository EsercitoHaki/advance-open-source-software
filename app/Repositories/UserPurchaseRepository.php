<?php

namespace App\Repositories;

use App\Models\UserPurchase;
use App\DTOs\UserPurchaseDTO;

class UserPurchaseRepository
{
    public function createPurchase(UserPurchaseDTO $data): UserPurchase
    {
        return UserPurchase::create($data->toArray());
    }

    public function getPurchasesByUserId(string $userId)
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
