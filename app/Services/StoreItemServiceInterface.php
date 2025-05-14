<?php

namespace App\Services;

interface StoreItemServiceInterface
{
    public function getStoreHeartItems(): array;
    public function getStoreMascotItems(string $userId): array;
}

