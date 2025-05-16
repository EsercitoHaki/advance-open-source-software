<?php

namespace App\Services\Interfaces;

use App\Repositories\Interfaces\UserPurchaseRepositoryInterface;

interface UserPurchaseServiceInterface
{
    public function getPurchaseHistory(string $userId): array;
    public function purchaseItem($user, int $itemId): array;
}
