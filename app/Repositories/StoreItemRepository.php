<?php

namespace App\Repositories;

use App\Models\StoreItem;
use Illuminate\Support\Collection;
use App\Repositories\Interfaces\StoreItemRepositoryInterface;

class StoreItemRepository implements StoreItemRepositoryInterface
{
    public function getStoreHeartItems(): Collection
    {
        return StoreItem::where('is_active', 1)
        ->where('item_type', 'Lives')
        ->get();
    }

    public function findItemById(int $itemId): ?StoreItem
    {
        return StoreItem::find($itemId);
    }

    public function getStoreMascotItems(string $userId): Collection
    {
        return StoreItem::where('item_type', 'Mascot')
            ->leftJoin('user_purchases', function ($join) use ($userId) {
                $join->on('store_items.item_id', '=', 'user_purchases.item_id')
                    ->where('user_purchases.user_id', '=', $userId);
            })
            ->select(
                'store_items.*',
                \DB::raw('CASE WHEN user_purchases.item_id IS NULL THEN 0 ELSE 1 END as is_purchased')
            )
            ->orderBy('is_purchased', 'asc')
            ->get();
    }
}
