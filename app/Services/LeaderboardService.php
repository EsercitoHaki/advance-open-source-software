<?php

namespace App\Services;

use App\DTOs\LeaderboardDTO;
use App\DTOs\LeaderboardResponseDTO;
use App\Repositories\Interfaces\LeaderboardRepositoryInterface;
use App\Services\Interfaces\LeaderboardServiceInterface;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\UserRepositoryInterface;

class LeaderboardService implements LeaderboardServiceInterface
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getLeaderboard(int $limit = 100): array
    {
        $usersWithTotalScore = $this->userRepository->getUsersWithTotalScore();

        $leaderboard = $usersWithTotalScore
            ->sortByDesc('total_score')
            ->values()
            ->take($limit)
            ->map(function ($user, $index) {
                return [
                    'rank' => $this->getRankByScore($user->total_score),
                    'position' => $index + 1,
                    'username' => $user->username,
                    'avatar' => $user->avatar,
                    'total_score' => $user->total_score,
                ];
            });

        return $leaderboard->toArray();
    }

    public function getUserRank(): ?array
    {
        $authUserId = Auth::id();

        $usersWithTotalScore = $this->userRepository->getUsersWithTotalScore()
            ->sortByDesc('total_score')
            ->values();

        $position = $usersWithTotalScore->search(fn ($user) => $user->user_id === $authUserId);

        if ($position === false) {
            return null;
        }

        $user = $usersWithTotalScore[$position];

        return [
            'rank' => $this->getRankByScore($user->total_score),
            'position' => $position + 1,
            'username' => $user->username,
            'avatar' => $user->avatar,
            'total_score' => $user->total_score,
        ];
    }

    protected function getRankByScore(int $score): string
    {
        return match (true) {
            $score <= 20 => 'Bronze',
            $score <= 50 => 'Silver',
            $score <= 100 => 'Gold',
            $score <= 200 => 'Platinum',
            $score > 200 => 'Diamond',
            default => 'Bronze',
        };
    }

    public function getFriendsLeaderboard(): array
    {
        $authUserId = Auth::id();
        
        if (!$authUserId) {
            return [];
        }

        $friendIds = $this->userRepository->getFriendIds($authUserId);
        
        if (empty($friendIds)) {
            return [];
        }

        $friendsWithScore = $this->userRepository->getUsersWithScoreByIds($friendIds);
        
        $friendsLeaderboard = $friendsWithScore
            ->sortByDesc('total_score')
            ->values()
            ->map(function ($friend, $index) {
                return [
                    'rank' => $this->getRankByScore($friend->total_score),
                    'position' => $index + 1,
                    'user_id' => $friend->user_id,
                    'username' => $friend->username,
                    'avatar' => $friend->avatar,
                    'total_score' => $friend->total_score,
                ];
            });

        return $friendsLeaderboard->toArray();
    }

    public function compareFriendsRank(): array
    {
        $authUserId = Auth::id();
        
        if (!$authUserId) {
            return [];
        }

        $currentUserRank = $this->getUserRank();
        
        $friendsRanks = $this->getFriendsLeaderboard();
        
        $allUsersForComparison = $friendsRanks;
        
        if ($currentUserRank) {
            $allUsersForComparison[] = array_merge($currentUserRank, [
                'user_id' => $authUserId,
                'is_current_user' => true
            ]);
        }

        $sortedComparison = collect($allUsersForComparison)
            ->sortByDesc('total_score')
            ->values()
            ->map(function ($user, $index) {
                return array_merge($user, [
                    'position' => $index + 1,
                    'is_current_user' => $user['is_current_user'] ?? false
                ]);
            });

        return $sortedComparison->toArray();
    }

    // protected function getRankByPercentile(int $position, int $total): string
    // {
    //     $percentile = $position / $total;

    //     return match (true) {
    //         $percentile <= 0.01 => 'Diamond',
    //         $percentile <= 0.05 => 'Platinum',
    //         $percentile <= 0.15 => 'Gold',
    //         $percentile <= 0.30 => 'Silver',
    //         default => 'Bronze',
    //     };
    // }
}
