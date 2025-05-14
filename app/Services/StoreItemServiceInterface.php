<?php

namespace App\Services;

use Illuminate\Support\Collection;

interface StoreItemServiceInterface
{
    public function getStoreHeartItems(): array;
    public function getStoreMascotItems(string $userId): array;
}

