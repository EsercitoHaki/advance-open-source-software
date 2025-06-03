<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\CheckInService;
use App\Services\Interfaces\UserDailyMissionServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\AppException;

class CheckInController extends Controller
{
    protected $checkInService;

    protected $userDailyMissionService;

    public function __construct(
        CheckInService $checkInService,
        UserDailyMissionServiceInterface $userDailyMissionService)
    {
        $this->checkInService = $checkInService;
        $this->userDailyMissionService = $userDailyMissionService;
    }

    public function checkIn(): JsonResponse
    {
        try {
            $user = Auth::user(); 
    
            $checkInResult = $this->checkInService->checkIn($user);

            $this->userDailyMissionService->recordAction($user->id, 'check_in');
    
            return response()->json([
                'success' => true,
                'message' => 'Điểm danh thành công',
                'data' => $checkInResult->toArray()
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

    public function getDateHistory(): JsonResponse
    {
        try {
            $user = Auth::user(); 
            $history = $this->checkInService->getCheckInDateHistory($user);

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
