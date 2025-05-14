<?php

namespace App\Repositories;

interface StoreItemRepositoryInterface
{
    public function getStoreHeartItems();
    public function findItemById(int $itemId): ?StoreItem;
    public function getStoreMascotItems(string $userId): Collection;
}
