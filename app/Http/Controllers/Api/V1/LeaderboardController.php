<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\LeaderboardServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LeaderboardController extends Controller
{
    protected $leaderboardService;
    
    public function __construct(LeaderboardServiceInterface $leaderboardService)
    {
        $this->leaderboardService = $leaderboardService;
    }
    
    public function index(Request $request): JsonResponse
    {
        $limit = $request->input('limit', 100);
        
        $leaderboard = $this->leaderboardService->getLeaderboard($limit);
        
        return response()->json([
            'success' => true,
            'data' => $leaderboard
        ]);
    }
    
    public function getUserRank(): JsonResponse
    {
        $userRank = $this->leaderboardService->getUserRank();

        if ($userRank === null) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $userRank
        ]);
    }
}