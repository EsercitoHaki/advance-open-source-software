<?php

namespace App\Repositories;

use App\Models\StoreItem;
use Illuminate\Support\Collection;

interface StoreItemRepositoryInterface
{
    public function getStoreHeartItems(): Collection;
    public function findItemById(int $itemId): ?StoreItem;
    public function getStoreMascotItems(string $userId): Collection;
}
