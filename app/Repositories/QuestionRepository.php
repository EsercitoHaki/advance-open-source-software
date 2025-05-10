<?php

namespace App\Repositories;

use App\Models\Question;
use App\Repositories\Interfaces\QuestionRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class QuestionRepository implements QuestionRepositoryInterface
{
    /**
     * Lấy danh sách tất cả câu hỏi
     *
     * @return Collection
     */
    public function getAllQuestions(): Collection
    {
        return Question::all();
    }

    /**
     * Lấy câu hỏi theo ID
     *
     * @param int $questionId
     * @return Question|null
     */
    public function getQuestionById(int $questionId): ?Question
    {
        return Question::find($questionId);
    }

    /**
     * Lấy danh sách câu hỏi theo lesson ID
     *
     * @param int $lessonId
     * @return Collection
     */
    public function getQuestionsByLessonId(int $lessonId): Collection
    {
        return Question::where('lesson_id', $lessonId)->get();
    }

    /**
     * Tạo câu hỏi mới
     *
     * @param array $data
     * @return Question
     */
    public function createQuestion(array $data): Question
    {
        return Question::create($data);
    }

    /**
     * Cập nhật câu hỏi
     *
     * @param int $questionId
     * @param array $data
     * @return Question|null
     */
    public function updateQuestion(int $questionId, array $data): ?Question
    {
        $question = Question::find($questionId);
        if ($question) {
            $question->update($data);
        }
        return $question;
    }

    /**
     * Xóa câu hỏi
     *
     * @param int $questionId
     * @return bool
     */
    public function deleteQuestion(int $questionId): bool
    {
        return Question::destroy($questionId) > 0;
    }
}
