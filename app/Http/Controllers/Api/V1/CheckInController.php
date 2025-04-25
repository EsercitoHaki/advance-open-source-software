<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\CheckInService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\AppException;

class CheckInController extends Controller
{
    protected $checkInService;

    public function __construct(CheckInService $checkInService)
    {
        $this->middleware('auth:api'); // Đảm bảo đã đăng nhập
        $this->checkInService = $checkInService;
    }

    public function checkIn(): JsonResponse
    {
        try {
            $user = Auth::user(); // Hoặc dùng JWTAuth::user() nếu bạn muốn
            $result = $this->checkInService->checkIn($user);

            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'coins' => $result['coins'],
                'streak' => $result['streak'],
            ]);
        } catch (AppException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
