<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\StoreItemService;
use App\Exceptions\AppException;
use Illuminate\Http\Request;
use App\Exceptions\ExpiredTokenException;

class StoreItemController extends Controller
{
    protected $storeItemService;

    public function __construct(StoreItemService $storeItemService)
    {
        $this->storeItemService = $storeItemService;
    }

    public function getStoreHeartItems()
    {
        try {
            $items = $this->storeItemService->getStoreHeartItems();

            return response()->json([
                'status' => 'success',
                'data' => $items
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

    public function getStoreMascotItems()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                throw new AppException('Người dùng không hợp lệ hoặc không tồn tại!');
            }

            $itemsStatus = $this->storeItemService->getStoreMascotItems($user->user_id);

            return response()->json([
                'status' => 'success',
                'data' => $itemsStatus
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
