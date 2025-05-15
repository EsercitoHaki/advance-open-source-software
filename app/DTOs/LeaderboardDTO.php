<?php

namespace App\DTOs;

class LeaderboardDTO
{
    public function __construct(
        public readonly int $position,
        public readonly string $userId,
        public readonly string $username,
        public readonly string $fullName,
        public readonly string $avatar,
        public readonly string $rank,
        public readonly float $totalScore,
        public readonly bool $isCurrentUser
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            position: $data['position'],
            userId: $data['user_id'],
            username: $data['username'],
            fullName: $data['full_name'] ?? '',
            avatar: $data['avatar'],
            rank: $data['rank'],
            totalScore: $data['total_score'],
            isCurrentUser: $data['is_current_user'] ?? false
        );
    }

    public function toArray(): array
    {
        return [
            'position' => $this->position,
            'user_id' => $this->userId,
            'username' => $this->username,
            'full_name' => $this->fullName,
            'avatar' => $this->avatar,
            'rank' => $this->rank,
            'total_score' => $this->totalScore,
            'is_current_user' => $this->isCurrentUser
        ];
    }
}