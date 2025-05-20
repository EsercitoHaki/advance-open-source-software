<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\StreakServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
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
     * Cập nhật streak cho người dùng khi hoàn thành bài học
     *
     * @param string $userId
     * @return array Thông tin về việc cập nhật streak
     */
    public function updateStreak(string $userId): array
    {
        try {
            // Get user information
            $user = $this->userRepository->getUserById($userId);
            if (!$user) {
                throw new \Exception('Không tìm thấy người dùng');
            }

            // Kiểm tra xem người dùng đã hoàn thành bài học hôm nay chưa
            $today = Carbon::now()->format('Y-m-d');
            $lastLessonDateKey = "user_{$userId}_last_lesson_date";
            $lastLessonDate = Cache::get($lastLessonDateKey);

            // Nếu không có thông tin về ngày hoàn thành bài học, lấy từ cơ sở dữ liệu
            $currentStreak = $user->current_streak;
            $longestStreak = $user->longest_streak;
            $streakUpdated = false;
            $streakMessage = '';

            // Nếu người dùng đã hoàn thành bài học hôm nay, không cần cập nhật streak
            if ($lastLessonDate === $today) {
                return [
                    'current_streak' => $currentStreak,
                    'longest_streak' => $longestStreak,
                    'streak_updated' => false,
                    'message' => 'Streak already updated today'
                ];
            }

            // Kiêm tra xem người dùng đã hoàn thành bài học hôm qua chưa
            // Nếu có, kiểm tra xem có tiếp tục streak không
            if ($lastLessonDate) {
                $yesterday = Carbon::now()->subDay()->format('Y-m-d');
                if ($lastLessonDate === $yesterday) {
                    // Continue streak
                    $currentStreak++;
                    $streakUpdated = true;
                    $streakMessage = 'Tuyệt vời! Bạn đã giữ được streak liên tục trong ' . $currentStreak . ' ngày!';
                } else {
                    // Reset streak
                    $currentStreak = 0;// về 0 ok chưa
                    $streakUpdated = true;
                    $streakMessage = 'Streak của bạn đã bị reset vì bạn không hoàn thành bài học hôm qua. Hãy cố gắng hơn nhé!';
                }
            } else {
                // Và với người dùng mới
// Lần đầu hoàn thành bài học
                $currentStreak = 1;  // Không phải 0, vì họ đã hoàn thành bài học hôm nay
                $streakUpdated = true;
                $streakMessage = 'Bạn đã bắt đầu một streak mới! Học mỗi ngày để duy trì chuỗi ngày thành tích nhé!';
            }

            // Cập nhật longest streak nếu current streak lớn hơn
            if ($currentStreak > $longestStreak) {
                $longestStreak = $currentStreak;
            }

            // Lưu thông tin streak vào cơ sở dữ liệu
            if ($streakUpdated) {
                $this->userRepository->updateStats($user, [
                    'current_streak' => $currentStreak,
                    'longest_streak' => $longestStreak
                ]);
            }

            // Cập nhật thông tin ngày hoàn thành bài học vào cache
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
     * Kiểm tra và reset streak cho người dùng
     * Mỗi ngày chạy một lần để kiểm tra xem người dùng có hoàn thành bài học hôm qua không
     * Nếu không, reset current_streak về 0
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
                    $this->userRepository->updateStats($user, ['current_streak' => 0]);// tự động reset
                    $resetCount++;
                }
            }

            Log::info("Daily streak check completed: {$resetCount} streaks were reset");
        } catch (\Exception $e) {
            Log::error('Error checking streaks: ' . $e->getMessage());
        }
    }
}
