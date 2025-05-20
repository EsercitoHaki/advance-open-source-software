<?php

namespace App\Repositories\Interfaces;

use App\Models\StoreItem;
use Illuminate\Support\Collection;
use App\Models\User;

interface StoreItemRepositoryInterface
{
    public function getStoreHeartItems(): Collection;
    public function findItemById(int $itemId): ?StoreItem;
    public function getStoreMascotItems(string $userId): Collection;
    public function getMascots(string $userId): Collection;
}
