<?php

namespace App\Services\Interfaces;

use App\Repositories\Interfaces\StoreItemRepositoryInterface;
use App\Models\User;

interface StoreItemServiceInterface
{
    public function getStoreHeartItems(): array;
    public function getStoreMascotItems(string $userId): array;
    public function getMascots(string $userId): array;
}

