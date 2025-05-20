<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\StreakServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StreakService implements StreakServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * StreakService constructor.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * Update user streak when a lesson is completed
     *
     * @param string $userId
     * @return array Information about the streak update
     */
    public function updateStreak(string $userId): array
    {
        try {
            // Get user information
            $user = $this->userRepository->getUserById($userId);
            if (!$user) {
                throw new \Exception('User not found');
            }

            // Use today's date as the key for checking if a lesson was completed today
            $today = Carbon::now()->format('Y-m-d');
            $lastLessonDateKey = "user_{$userId}_last_lesson_date";
            $lastLessonDate = Cache::get($lastLessonDateKey);

            // Get the current streak values
            $currentStreak = $user->current_streak;
            $longestStreak = $user->longest_streak;
            $streakUpdated = false;
            $streakMessage = '';

            // If the user has already completed a lesson today, no need to update streak
            if ($lastLessonDate === $today) {
                return [
                    'current_streak' => $currentStreak,
                    'longest_streak' => $longestStreak,
                    'streak_updated' => false,
                    'message' => 'Streak already updated today'
                ];
            }

            // Check if the last lesson was completed yesterday to continue streak
            if ($lastLessonDate) {
                $yesterday = Carbon::now()->subDay()->format('Y-m-d');
                if ($lastLessonDate === $yesterday) {
                    // Continue streak
                    $currentStreak++;
                    $streakUpdated = true;
                    $streakMessage = 'Streak continued! You\'ve maintained your streak for ' . $currentStreak . ' days!';
                } else {
                    // Streak broken - reset to 1
                    $currentStreak = 1;
                    $streakUpdated = true;
                    $streakMessage = 'New streak started! Complete lessons daily to maintain your streak!';
                }
            } else {
                // First time completion - start streak at 1
                $currentStreak = 1;
                $streakUpdated = true;
                $streakMessage = 'Streak started! Complete lessons daily to maintain your streak!';
            }

            // Update longest streak if current streak is higher
            if ($currentStreak > $longestStreak) {
                $longestStreak = $currentStreak;
            }

            // Save the updated streak values
            if ($streakUpdated) {
                $this->userRepository->updateStats($user, [
                    'current_streak' => $currentStreak,
                    'longest_streak' => $longestStreak
                ]);
            }

            // Update last lesson completion date
            Cache::put($lastLessonDateKey, $today, Carbon::now()->endOfDay()->diffInSeconds(Carbon::now()));

            return [
                'current_streak' => $currentStreak,
                'longest_streak' => $longestStreak,
                'streak_updated' => $streakUpdated,
                'message' => $streakMessage
            ];
        } catch (\Exception $e) {
            Log::error('Error updating streak: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Check and reset streaks for users who haven't completed lessons
     * This method should be called by a scheduled job daily
     */
    public function checkAndResetStreaks(): void
    {
        try {
            // Get all users with active streaks
            $users = User::where('current_streak', '>', 0)->get();
            $resetCount = 0;

            foreach ($users as $user) {
                $lastLessonDateKey = "user_{$user->user_id}_last_lesson_date";
                $lastLessonDate = Cache::get($lastLessonDateKey);
                
                // If no last lesson date found or it's not yesterday, reset streak
                if (!$lastLessonDate || Carbon::parse($lastLessonDate)->diffInDays(Carbon::now()) > 1) {
                    // Reset current streak to 0
                    $this->userRepository->updateStats($user, ['current_streak' => 0]);
                    $resetCount++;
                }
            }

            Log::info("Daily streak check completed: {$resetCount} streaks were reset");
        } catch (\Exception $e) {
            Log::error('Error checking streaks: ' . $e->getMessage());
        }
    }
}
