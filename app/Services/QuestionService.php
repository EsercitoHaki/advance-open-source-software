<?php

namespace App\Services;

use App\DTOs\QuestionDTO;
use App\Exceptions\DataNotFoundException;
use App\Repositories\Interfaces\QuestionRepositoryInterface;
use App\Services\Interfaces\QuestionServiceInterface;
use Illuminate\Support\Collection;

class QuestionService implements QuestionServiceInterface
{
    protected $questionRepository;

    public function __construct(QuestionRepositoryInterface $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    /**
     * Lấy tất cả câu hỏi.
     *
     * @return Collection
     */
    public function getAllQuestions(): Collection
    {
        $questions = $this->questionRepository->getAllQuestions();

        return $questions->map(function ($question) {
            return QuestionDTO::fromModel($question);
        });
    }

    /**
     * Lấy câu hỏi theo ID.
     *
     * @param int $questionId
     * @return QuestionDTO|null
     * @throws DataNotFoundException
     */
    public function getQuestionById(int $questionId): ?QuestionDTO
    {
        $question = $this->questionRepository->getQuestionById($questionId);

        if (!$question) {
            throw new DataNotFoundException('Không tìm thấy câu hỏi');
        }

        return QuestionDTO::fromModel($question);
    }

    /**
     * Lấy danh sách câu hỏi theo bài học.
     *
     * @param int $lessonId
     * @return Collection
     */
    public function getQuestionsByLessonId(int $lessonId): Collection
    {
        $questions = $this->questionRepository->getQuestionsByLessonId($lessonId);

        return $questions->map(function ($question) {
            return QuestionDTO::fromModel($question);
        });
    }

    /**
     * Tạo câu hỏi mới.
     *
     * @param array $data
     * @return QuestionDTO
     */
    public function createQuestion(array $data): QuestionDTO
    {
        $question = $this->questionRepository->createQuestion($data);

        return QuestionDTO::fromModel($question);
    }

    /**
     * Cập nhật câu hỏi.
     *
     * @param int $questionId
     * @param array $data
     * @return QuestionDTO|null
     * @throws DataNotFoundException
     */
    public function updateQuestion(int $questionId, array $data): ?QuestionDTO
    {
        $question = $this->questionRepository->updateQuestion($questionId, $data);

        if (!$question) {
            throw new DataNotFoundException('Không tìm thấy câu hỏi để cập nhật');
        }

        return QuestionDTO::fromModel($question);
    }

    /**
     * Xóa câu hỏi.
     *
     * @param int $questionId
     * @return bool
     * @throws DataNotFoundException
     */
    public function deleteQuestion(int $questionId): bool
    {
        $result = $this->questionRepository->deleteQuestion($questionId);

        if (!$result) {
            throw new DataNotFoundException('Không tìm thấy câu hỏi để xóa');
        }

        return true;
    }
}