<?php

namespace App\Services;

use App\Exceptions\DataNotFoundException;
use App\Exceptions\InvalidParamException;
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
     * @throws DataNotFoundException
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
     * @throws InvalidParamException
     */
    public function completeLesson(string $userId, int $lessonId, array $userAnswers): array;

    /**
     * Xử lý việc nộp từng câu trả lời một và trả về phản hồi ngay lập tức
     *
     * @param string $userId
     * @param int $lessonId
     * @param int $questionId
     * @param int $selectedOptionId
     * @return array Trả về kết quả bao gồm thông tin câu trả lời và giải thích nếu sai
     * @throws InvalidParamException
     * @throws DataNotFoundException
     */
    public function submitSingleAnswer(string $userId, int $lessonId, int $questionId, int $selectedOptionId): array;

    /**
     * Hoàn thành bài học sau khi đã trả lời các câu hỏi một cách riêng lẻ
     *
     * @param string $userId
     * @param int $lessonId
     * @return array Trả về kết quả tổng hợp của bài học
     * @throws InvalidParamException
     */
    public function finalizeLessonProgress(string $userId, int $lessonId): array;

    /**
     * Lấy thống kê học tập của người dùng
     *
     * @param string $userId
     * @return array
     */
    public function getUserLearningStats(string $userId): array;

    /**
     * Kiểm tra xem người dùng đã bắt đầu một bài học hay chưa
     *
     * @param string $userId
     * @param int $lessonId
     * @return bool
     */
    public function hasStartedLesson(string $userId, int $lessonId): bool;

    /**
     * Kiểm tra xem người dùng đã hoàn thành một bài học hay chưa
     *
     * @param string $userId
     * @param int $lessonId
     * @return bool
     */
    public function hasCompletedLesson(string $userId, int $lessonId): bool;
}