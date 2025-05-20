<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\StoreItem;
use App\Models\UserPurchase;
use App\DTOs\UserPurchaseDTO;
use Carbon\Carbon;
use App\Repositories\UserPurchaseRepository;
use App\Repositories\StoreItemRepository;
use App\Exceptions\AppException;
use App\Services\Interfaces\UserPurchaseServiceInterface;

class UserPurchaseService implements UserPurchaseServiceInterface
{
    protected $userPurchaseRepository;
    protected $storeItemRepository;

    public function __construct(
        UserPurchaseRepository $userPurchaseRepository,
        StoreItemRepository $storeItemRepository
    ) {
        $this->userPurchaseRepository = $userPurchaseRepository;
        $this->storeItemRepository = $storeItemRepository;
    }

    public function purchaseItem($user, int $itemId): array
    {
        if (!$user) {
            throw new AppException('Người dùng không hợp lệ hoặc không tồn tại!');
        }

        return DB::transaction(function () use ($user, $itemId) {
            $item = $this->storeItemRepository->findItemById($itemId);
            if (!$item) {
                throw new AppException('Item không tồn tại.');
            }

            if ($user->coins < $item->item_price) {
                throw new AppException('Bạn không đủ xu để mua item này.');
            }

            if (
                $item->item_type === 'Lives' &&
                $user->lives >= 5 &&
                $this->userPurchaseRepository->hasPurchasedItem($user->user_id, $item->item_id)
            ) {
                throw new AppException('Bạn đã đạt số lượng tim tối đa.');
            }

            if (
                $item->item_type === 'Mascot' &&
                $this->userPurchaseRepository->hasPurchasedItem($user->user_id, $item->item_id)
            ) {
                throw new AppException('Bạn đã mua linh vật này rồi.');
            }
            
            $active = ($item->item_type === 'Mascot') ? true : null;

            $user->coins -= $item->item_price;
            $user->save();

            $dto = new UserPurchaseDTO(
                user_id: $user->user_id,
                item_id: $item->item_id,
                active: $active,
                purchase_date: Carbon::now()->toDateTimeString()
            );

            $this->userPurchaseRepository->createPurchase($dto->toArray());

            if ($item->item_type === 'Lives') {
                $user->lives += $item->lives_amount ?? 0;
                $user->save();
            }

            return [
                'message' => 'Mua item thành công!',
                'remaining_coins' => $user->coins,
                'total_lives' => $user->lives
            ];
        });
    }

    /**
     * Lấy lịch sử mua item của user
     */
    public function getPurchaseHistory($user): array
    {
        if (!$user) {
            throw new AppException('Người dùng không hợp lệ hoặc không tồn tại!');
        }

        $purchaseHistory = $this->userPurchaseRepository->getPurchasesByUserId($user->user_id);

        if ($purchaseHistory->isEmpty()) {
            throw new AppException('Không có lịch sử mua item.');
        }

        return $purchaseHistory->map(fn($userpurchase) => UserPurchaseDTO::fromModel($userpurchase))->toArray();
    }
}
