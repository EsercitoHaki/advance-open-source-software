<?php

namespace App\Services\Interfaces;

use App\DTOs\LeaderboardResponseDTO;

interface LeaderboardServiceInterface
{
    public function getLeaderboard(int $limit = 100): array;
    public function getUserRank(): ?array;
}