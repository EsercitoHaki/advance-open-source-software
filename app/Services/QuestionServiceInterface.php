<?php

namespace App\Services;

use App\DTOs\QuestionDTO;
use Illuminate\Support\Collection;

interface QuestionServiceInterface
{
    /**
     * Lấy tất cả câu hỏi.
     *
     * @return Collection
     */
    public function getAllQuestions(): Collection;

    /**
     * Lấy câu hỏi theo ID.
     *
     * @param int $questionId
     * @return QuestionDTO|null
     */
    public function getQuestionById(int $questionId): ?QuestionDTO;

    /**
     * Lấy danh sách câu hỏi theo bài học.
     *
     * @param int $lessonId
     * @return Collection
     */
    public function getQuestionsByLessonId(int $lessonId): Collection;

    /**
     * Tạo câu hỏi mới.
     *
     * @param array $data
     * @return QuestionDTO
     */
    public function createQuestion(array $data): QuestionDTO;

    /**
     * Cập nhật câu hỏi.
     *
     * @param int $questionId
     * @param array $data
     * @return QuestionDTO|null
     */
    public function updateQuestion(int $questionId, array $data): ?QuestionDTO;

    /**
     * Xóa câu hỏi.
     *
     * @param int $questionId
     * @return bool
     */
    public function deleteQuestion(int $questionId): bool;
}