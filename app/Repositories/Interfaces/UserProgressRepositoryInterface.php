<?php

namespace App\Repositories\Interfaces;

use App\Models\UserProgress;
use Illuminate\Support\Collection;

interface UserProgressRepositoryInterface
{
    /**
     * Lấy tiến độ học tập của người dùng cho một bài học cụ thể
     *
     * @param string $userId
     * @param int $lessonId
     * @return UserProgress|null
     */
    public function getUserProgress(string $userId, int $lessonId): ?UserProgress;

    /**
     * Lấy tất cả tiến độ học tập của một người dùng
     *
     * @param string $userId
     * @return Collection
     */
    public function getAllUserProgress(string $userId): Collection;

    /**
     * Bắt đầu một bài học (ghi nhận thời gian bắt đầu)
     *
     * @param string $userId
     * @param int $lessonId
     * @return UserProgress
     */
    public function startLesson(string $userId, int $lessonId): UserProgress;    /**
               * Cập nhật điểm số và trạng thái hoàn thành bài học
               *
               * @param string $userId
               * @param int $lessonId
               * @param float $score
               * @param bool $completed
               * @param int|null $elapsedTime Thời gian đã sử dụng (tính bằng giây)
               * @return UserProgress
               */
    public function updateProgress(string $userId, int $lessonId, float $score, bool $completed = false, ?int $elapsedTime = null): UserProgress;

    /**
     * Lấy thống kê học tập của người dùng (tổng số bài học, số bài hoàn thành, điểm trung bình)
     *
     * @param string $userId
     * @return array
     */
    public function getUserLearningStats(string $userId): array;

    /**
     * Lấy danh sách các bài học người dùng đã hoàn thành
     *
     * @param string $userId
     * @return Collection
     */
    public function getCompletedLessons(string $userId): Collection;

    /**
     * Lấy danh sách các bài học người dùng đang học dở
     *
     * @param string $userId
     * @return Collection
     */
    public function getInProgressLessons(string $userId): Collection;
}
