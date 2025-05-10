<?php

namespace App\Repositories\Interfaces;

use App\Models\Question;
use Illuminate\Support\Collection;

interface QuestionRepositoryInterface
{
    /**
     * Lấy danh sách tất cả câu hỏi.
     *
     * @return Collection
     */
    public function getAllQuestions(): Collection;

    /**
     * Lấy câu hỏi theo ID.
     *
     * @param int $questionId
     * @return Question|null
     */
    public function getQuestionById(int $questionId): ?Question;

    /**
     * Lấy danh sách câu hỏi theo lesson ID.
     *
     * @param int $lessonId
     * @return Collection
     */
    public function getQuestionsByLessonId(int $lessonId): Collection;

    /**
     * Tạo câu hỏi mới.
     *
     * @param array $data
     * @return Question
     */
    public function createQuestion(array $data): Question;

    /**
     * Cập nhật câu hỏi.
     *
     * @param int $questionId
     * @param array $data
     * @return Question|null
     */
    public function updateQuestion(int $questionId, array $data): ?Question;

    /**
     * Xóa câu hỏi.
     *
     * @param int $questionId
     * @return bool
     */
    public function deleteQuestion(int $questionId): bool;
}
