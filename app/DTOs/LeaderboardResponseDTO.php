<?php

namespace App\DTOs;

class LeaderboardResponseDTO
{
    public function __construct(
        public readonly array $leaderboard,
        public readonly ?LeaderboardDTO $currentUserRank,
        public readonly int $totalUsers
    ) {}

    public function toArray(): array
    {
        return [
            'leaderboard' => array_map(fn($item) => $item->toArray(), $this->leaderboard),
            'current_user' => $this->currentUserRank?->toArray(),
            'total_users' => $this->totalUsers
        ];
    }
}
