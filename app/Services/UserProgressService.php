<?php

namespace App\Services;

use App\Models\UserProgress;
use App\Repositories\QuestionRepositoryInterface;
use App\Repositories\UserProgressRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserProgressService implements UserProgressServiceInterface
{
    /**
     * @var UserProgressRepositoryInterface
     */
    protected $userProgressRepository;

    /**
     * @var QuestionRepositoryInterface
     */
    protected $questionRepository;

    /**
     * UserProgressService constructor.
     *
     * @param UserProgressRepositoryInterface $userProgressRepository
     * @param QuestionRepositoryInterface $questionRepository
     */
    public function __construct(
        UserProgressRepositoryInterface $userProgressRepository,
        QuestionRepositoryInterface $questionRepository
    ) {
        $this->userProgressRepository = $userProgressRepository;
        $this->questionRepository = $questionRepository;
    }

    /**
     * Lấy tiến độ học tập của người dùng cho một bài học cụ thể
     *
     * @param string $userId
     * @param int $lessonId
     * @return UserProgress|null
     */
    public function getUserProgress(string $userId, int $lessonId): ?UserProgress
    {
        return $this->userProgressRepository->getUserProgress($userId, $lessonId);
    }

    /**
     * Lấy tất cả tiến độ học tập của một người dùng
     *
     * @param string $userId
     * @return Collection
     */
    public function getAllUserProgress(string $userId): Collection
    {
        return $this->userProgressRepository->getAllUserProgress($userId);
    }

    /**
     * Bắt đầu một bài học
     *
     * @param string $userId
     * @param int $lessonId
     * @return UserProgress
     */
    public function startLesson(string $userId, int $lessonId): UserProgress
    {
        return $this->userProgressRepository->startLesson($userId, $lessonId);
    }

    /**
     * Tính điểm và cập nhật tiến độ học tập khi người dùng hoàn thành bài học
     *
     * @param string $userId
     * @param int $lessonId
     * @param array $userAnswers [questionId => optionId]
     * @return array Trả về kết quả bao gồm điểm số và thông tin câu trả lời
     */
    public function completeLesson(string $userId, int $lessonId, array $userAnswers): array
    {
        // Bắt đầu transaction để đảm bảo tính nhất quán của dữ liệu
        return DB::transaction(function () use ($userId, $lessonId, $userAnswers) {
            // Lấy tất cả câu hỏi của bài học
            $questions = $this->questionRepository->getQuestionsByLessonId($lessonId);

            $totalScore = 0;
            $maxScore = 0;
            $results = [];

            foreach ($questions as $question) {
                $maxScore += $question->score;
                $questionId = $question->question_id;

                // Kiểm tra xem người dùng có trả lời câu hỏi này không
                if (!isset($userAnswers[$questionId])) {
                    continue;
                }

                $selectedOptionId = $userAnswers[$questionId];

                // Kiểm tra xem đáp án có đúng không
                $isCorrect = DB::table('options')
                    ->where('option_id', $selectedOptionId)
                    ->where('question_id', $questionId)
                    ->where('is_correct', true)
                    ->exists();

                // Nếu đúng, cộng điểm cho người dùng
                $earnedScore = $isCorrect ? $question->score : 0;
                $totalScore += $earnedScore;

                // Lấy thông tin về đáp án đã chọn và đáp án đúng
                $selectedOption = DB::table('options')
                    ->where('option_id', $selectedOptionId)
                    ->first();

                $correctOption = DB::table('options')
                    ->where('question_id', $questionId)
                    ->where('is_correct', true)
                    ->first();

                // Lưu kết quả câu hỏi
                $results[] = [
                    'question_id' => $questionId,
                    'question_text' => $question->question_text,
                    'selected_option_id' => $selectedOptionId,
                    'selected_option_text' => $selectedOption->option_text,
                    'correct_option_id' => $correctOption->option_id,
                    'correct_option_text' => $correctOption->option_text,
                    'is_correct' => $isCorrect,
                    'score' => $earnedScore,
                    'explanation' => $isCorrect ? null : $question->explanation
                ];
            }

            // Cập nhật tiến độ học tập
            $finalScore = $maxScore > 0 ? ($totalScore / $maxScore) * 100 : 0;
            $userProgress = $this->userProgressRepository->updateProgress(
                $userId,
                $lessonId,
                $finalScore,
                true
            );

            // Trả về kết quả
            return [
                'total_score' => $finalScore,
                'max_score' => 100,
                'passed' => $finalScore >= 70, // Giả định rằng điểm đậu là 70%
                'question_results' => $results
            ];
        });
    }

    /**
     * Lấy thống kê học tập của người dùng
     *
     * @param string $userId
     * @return array
     */
    public function getUserLearningStats(string $userId): array
    {
        return $this->userProgressRepository->getUserLearningStats($userId);
    }
}