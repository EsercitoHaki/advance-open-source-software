<?php

namespace App\Services;

use App\Models\UserProgress;
use Illuminate\Support\Collection;

interface UserProgressServiceInterface
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
     * Bắt đầu một bài học
     *
     * @param string $userId
     * @param int $lessonId
     * @return UserProgress
     */
    public function startLesson(string $userId, int $lessonId): UserProgress;

    /**
     * Tính điểm và cập nhật tiến độ học tập khi người dùng hoàn thành bài học
     *
     * @param string $userId
     * @param int $lessonId
     * @param array $userAnswers [questionId => optionId]
     * @return array Trả về kết quả bao gồm điểm số và thông tin câu trả lời
     */
    public function completeLesson(string $userId, int $lessonId, array $userAnswers): array;

    /**
     * Lấy thống kê học tập của người dùng
     *
     * @param string $userId
     * @return array
     */
    public function getUserLearningStats(string $userId): array;
}