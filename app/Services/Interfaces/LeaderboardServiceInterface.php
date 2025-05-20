<?php

namespace App\Services\Interfaces;

use App\DTOs\LeaderboardResponseDTO;

interface LeaderboardServiceInterface
{
    public function getLeaderboard(int $limit = 10, int $page = 1): LeaderboardResponseDTO;
    public function getUserLeaderboardPosition(string $userId): ?int;
}