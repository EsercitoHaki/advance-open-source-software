<?php

namespace App\Services;

interface UserPurchaseServiceInterface
{
    public function getPurchaseHistory(string $userId): array;
    public function purchaseItem($user, int $itemId): array;
}
