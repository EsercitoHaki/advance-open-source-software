<?php

namespace App\Repositories\Interfaces;

use App\Models\UserPurchase;
use Illuminate\Support\Collection;

interface UserPurchaseRepositoryInterface
{
    public function createPurchase(array $data): UserPurchase;
    public function getPurchasesByUserId(string $userId): Collection;
    public function hasPurchasedItem(string $userId, int $itemId): bool;
}