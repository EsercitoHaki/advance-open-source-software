<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\Interfaces\UserDailyMissionServiceInterface;
use Illuminate\Support\Facades\Auth;

class UserDailyMissionController extends Controller
{
    private UserDailyMissionServiceInterface $userDailyMissionService;

    public function __construct(UserDailyMissionServiceInterface $userDailyMissionService)
    {
        $this->userDailyMissionService = $userDailyMissionService;
    }

    public function getDailyMissions(): JsonResponse
    {
        $userId = Auth::id();
        $missions = $this->userDailyMissionService->getUserDailyMissions($userId);
        
        return response()->json([
            'missions' => $missions,
            'total' => count($missions)
        ]);
    }

    public function updateProgress(Request $request, int $missionId): JsonResponse
    {
        $userId = Auth::id();
        $progressIncrement = $request->input('progress_increment', 1);
        
        $updatedMission = $this->userDailyMissionService->updateMissionProgress(
            $userId, 
            $missionId, 
            $progressIncrement
        );
        
        if (!$updatedMission) {
            return response()->json([
                'message' => 'Không tìm thấy nhiệm vụ hôm nay hoặc nhiệm vụ đã hoàn thành.'
            ], 404);
        }
        
        return response()->json([
            'mission' => $updatedMission,
            'message' => $updatedMission->is_completed 
                ? 'Đã hoàn thành nhiệm vụ! Bạn có thể nhận phần thưởng.' 
                : 'Cập nhật tiến độ thành công.'
        ]);
    }

    public function claimReward(int $userMissionId): JsonResponse
    {
        $userId = Auth::id();
        $result = $this->userDailyMissionService->claimMissionReward($userId, $userMissionId);
        
        if (!$result) {
            return response()->json([
                'message' => 'Không thể nhận phần thưởng. Nhiệm vụ chưa hoàn thành, đã nhận thưởng hoặc không tồn tại.'
            ], 400);
        }
        
        return response()->json([
            'mission' => $result,
            'message' => 'Nhận phần thưởng thành công! Bạn nhận được ' . $result->mission->reward_coins . ' xu.'
        ]);
    }
}