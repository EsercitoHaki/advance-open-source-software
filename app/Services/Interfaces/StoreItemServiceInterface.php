<?php

namespace App\Services\Interfaces;

use App\Repositories\Interfaces\StoreItemRepositoryInterface;

interface StoreItemServiceInterface
{
    public function getStoreHeartItems(): array;
    public function getStoreMascotItems(string $userId): array;
}

