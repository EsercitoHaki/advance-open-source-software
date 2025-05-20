<?php

namespace App\Services\Interfaces;

interface StreakServiceInterface
{
    /**
     * Update user streak when a lesson is completed
     *
     * @param string $userId
     * @return array Information about the streak update
     */
    public function updateStreak(string $userId): array;

    /**
     * Check and reset streaks for users who haven't completed lessons
     * This method should be called by a scheduled job daily
     */
    public function checkAndResetStreaks(): void;
}
