<?php

namespace App\Services;

use App\DTOs\LeaderboardDTO;
use App\DTOs\LeaderboardResponseDTO;
use App\Repositories\Interfaces\LeaderboardRepositoryInterface;
use App\Services\Interfaces\LeaderboardServiceInterface;
use Illuminate\Support\Facades\Auth;

class LeaderboardService implements LeaderboardServiceInterface
{
    public function __construct(
        private LeaderboardRepositoryInterface $leaderboardRepository
    ) {}

    public function getLeaderboard(int $limit = 10, int $page = 1): LeaderboardResponseDTO
    {
        $leaderboardData = $this->leaderboardRepository->getLeaderboard($limit, $page);
        $totalUsers = $this->leaderboardRepository->getTotalUsers();
        
        $currentUserId = Auth::id();
        $currentUserRank = null;
        
        $leaderboardDTOs = [];
        $position = ($page - 1) * $limit + 1;
        
        foreach ($leaderboardData as $index => $userData) {
            $isCurrentUser = $currentUserId && $userData->user_id === $currentUserId;
            
            $leaderboardDTO = LeaderboardDTO::fromArray([
                'position' => $position + $index,
                'user_id' => $userData->user_id,
                'username' => $userData->username,
                'full_name' => $userData->full_name,
                'avatar' => $userData->avatar,
                'rank' => $userData->rank ?? 'Bronze',
                'total_score' => $userData->total_score ?? 0,
                'is_current_user' => $isCurrentUser
            ]);
            
            $leaderboardDTOs[] = $leaderboardDTO;
            
            if ($isCurrentUser) {
                $currentUserRank = $leaderboardDTO;
            }
        }
        
        if ($currentUserId && !$currentUserRank) {
            $currentUserData = $this->leaderboardRepository->getUserRank($currentUserId);
            if ($currentUserData) {
                $currentUserRank = LeaderboardDTO::fromArray([
                    'position' => $currentUserData->position,
                    'user_id' => $currentUserData->user_id,
                    'username' => $currentUserData->username,
                    'full_name' => $currentUserData->full_name,
                    'avatar' => $currentUserData->avatar,
                    'rank' => $currentUserData->rank ?? 'Bronze',
                    'total_score' => $currentUserData->total_score ?? 0,
                    'is_current_user' => true
                ]);
            }
        }
        
        return new LeaderboardResponseDTO(
            leaderboard: $leaderboardDTOs,
            currentUserRank: $currentUserRank,
            totalUsers: $totalUsers
        );
    }

    public function getUserLeaderboardPosition(string $userId): ?int
    {
        $userData = $this->leaderboardRepository->getUserRank($userId);
        return $userData ? $userData->position : null;
    }
}