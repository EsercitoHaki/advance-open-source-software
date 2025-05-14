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
        $this->checkInService = $checkInService;
    }

    public function checkIn(): JsonResponse
    {
        try {
            $user = Auth::user(); 
    
            $checkInResult = $this->checkInService->checkIn($user);
    
            return response()->json([
                'success' => true,
                'message' => 'Điểm danh thành công',
                'data' => $checkInResult,
            ]);
        } catch (AppException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function getHistory(): JsonResponse
    {
        try {
            $user = Auth::user(); 
            $history = $this->checkInService->getCheckInHistory($user);

            return response()->json([
                'success' => true,
                'data' => $history,
            ]);
        } catch (AppException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        } 
    }
}
