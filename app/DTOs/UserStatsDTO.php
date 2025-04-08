<?php
namespace App\DTOs;

class UserStatsDTO
{
    public int $coins;
    public int $lives;
    public int $currentStreak;
    public int $longestStreak;
    public ?array $learningProgress;

    /**
     * Constructor to initialize the DTO
     * 
     * @param int $coins
     * @param int $lives
     * @param int $currentStreak
     * @param int $longestStreak
     * @param array|null $learningProgress
     */
    public function __construct(
        int $coins,
        int $lives,
        int $currentStreak,
        int $longestStreak,
        ?array $learningProgress = null
    ) {
        $this->coins = $coins;
        $this->lives = $lives;
        $this->currentStreak = $currentStreak;
        $this->longestStreak = $longestStreak;
        $this->learningProgress = $learningProgress;
    }

    /**
     * Create a new DTO instance from a model
     * 
     * @param \App\Models\User $user
     * @param array|null $learningProgress
     * @return self
     */
    public static function fromUser($user, ?array $learningProgress = null): self
    {
        return new self(
            $user->coins,
            $user->lives,
            $user->current_streak,
            $user->longest_streak,
            $learningProgress
        );
    }

    /**
     * Convert to array
     * 
     * @return array
     */
    public function toArray(): array
    {
        return [
            'coins' => $this->coins,
            'lives' => $this->lives,
            'current_streak' => $this->currentStreak,
            'longest_streak' => $this->longestStreak,
            'learning_progress' => $this->learningProgress,
        ];
    }
}
