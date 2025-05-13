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

    /**
     * Get daily missions for the authenticated user
     */
    public function getDailyMissions(): JsonResponse
    {
        $userId = Auth::id();
        $missions = $this->userDailyMissionService->getUserDailyMissions($userId);
        
        return response()->json([
            'missions' => $missions,
            'total' => count($missions)
        ]);
    }

    /**
     * Update mission progress
     */
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
                'message' => 'Mission not found for today'
            ], 404);
        }
        
        return response()->json([
            'mission' => $updatedMission,
            'message' => $updatedMission->is_completed 
                ? 'Mission completed! You can now claim your reward.' 
                : 'Progress updated successfully.'
        ]);
    }

    /**
     * Claim reward for a completed mission
     */
    public function claimReward(int $userMissionId): JsonResponse
    {
        $userId = Auth::id();
        $result = $this->userDailyMissionService->claimMissionReward($userId, $userMissionId);
        
        if (!$result) {
            return response()->json([
                'message' => 'Cannot claim reward. Either the mission is not completed, already claimed, or not found.'
            ], 400);
        }
        
        return response()->json([
            'mission' => $result,
            'message' => 'Reward claimed successfully! You earned ' . $result->mission->reward_coins . ' coins.'
        ]);
    }
}