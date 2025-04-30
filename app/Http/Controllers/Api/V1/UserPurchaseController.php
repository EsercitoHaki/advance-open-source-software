<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\UserPurchaseService;
use App\Exceptions\AppException;
use Illuminate\Http\Request;

class UserPurchaseController extends Controller
{
    protected $userPurchaseService;

    public function __construct(UserPurchaseService $userPurchaseService)
    {
        $this->userPurchaseService = $userPurchaseService;
    }

    /**
     * Mua item (tim hoặc linh vật)
     */
    public function purchaseItem(Request $request)
    {
        try {
            $user = Auth::user(); 
            $itemId = $request->input('item_id');

            if (!$itemId) {
                throw new AppException('Thiếu item_id.');
            }

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
}
