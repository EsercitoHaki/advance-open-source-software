<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\LeaderboardServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LeaderboardController extends Controller
{
    public function __construct(
        private LeaderboardServiceInterface $leaderboardService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $limit = $request->input('limit', 10);
        $page = $request->input('page', 1);
        
        $leaderboardResponse = $this->leaderboardService->getLeaderboard($limit, $page);
        
        return response()->json([
            'status' => 'success',
            'data' => $leaderboardResponse->toArray(),
            'meta' => [
                'page' => (int)$page,
                'limit' => (int)$limit,
                'total' => $leaderboardResponse->totalUsers
            ]
        ]);
    }

    public function getCurrentUserRank(): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Người dùng chưa đăng nhập'
            ], 401);
        }
        
        $userId = auth()->id();
        $position = $this->leaderboardService->getUserLeaderboardPosition($userId);
        
        if ($position === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy thứ hạng của người dùng'
            ], 404);
        }
        
        return response()->json([
            'status' => 'success',
            'data' => [
                'position' => $position
            ]
        ]);
    }
}