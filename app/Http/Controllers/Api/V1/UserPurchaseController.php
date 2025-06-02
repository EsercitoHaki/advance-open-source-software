<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\UserPurchaseService;
use App\Exceptions\AppException;
use Illuminate\Http\Request;
use App\Exceptions\ExpiredTokenException;

class UserPurchaseController extends Controller
{
    protected $userPurchaseService;

    public function __construct(UserPurchaseService $userPurchaseService)
    {
        $this->userPurchaseService = $userPurchaseService;
    }

    public function purchaseItem($itemId)
    {
        $user = Auth::user();

        if (!$user) {
            throw new AppException('Người dùng không hợp lệ hoặc không tồn tại!');
        }
        if (!$itemId) {
            throw new AppException('Thiếu item_id.');
        }

        try {
            $result = $this->userPurchaseService->purchaseItem($user, (int)$itemId);

            return response()->json([
                'status' => 'success',
                'message' => $result['message'],
                'remaining_coins' => $result['remaining_coins'],
                'total_lives' => $result['total_lives']
            ], 200);

        } catch (AppException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function getPurchaseHistory()
    {
        try {
            $user = Auth::user();
            $history = $this->userPurchaseService->getPurchaseHistory($user);

            return response()->json([
                'status' => 'success',
                'data' => $history
            ], 200);

        } catch (AppException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // UserPurchaseController.php
    public function updateMascotActive($mascotId)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                throw new AppException('Người dùng không hợp lệ hoặc không tồn tại!');
            }

            $result = $this->userPurchaseService->updateMascotActive($user->user_id, $mascotId);

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thành công!',
                'data' => $result
            ], 200);

        } catch (ExpiredTokenException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Đã xảy ra lỗi: ' . $e->getMessage()
            ], 500);
        }
    }
}
