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
                    'explanation' => $question->explanation // Luôn trả về giải thích, kể cả khi đúng
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
     * Xử lý việc nộp từng câu trả lời một và trả về phản hồi ngay lập tức
     *
     * @param string $userId
     * @param int $lessonId
     * @param int $questionId
     * @param int $selectedOptionId
     * @return array Trả về kết quả bao gồm thông tin câu trả lời và giải thích nếu sai
     */
    public function submitSingleAnswer(string $userId, int $lessonId, int $questionId, int $selectedOptionId): array
    {
        // Kiểm tra xem câu hỏi có thuộc về bài học không
        $question = $this->questionRepository->getQuestionById($questionId);

        if (!$question || $question->lesson_id != $lessonId) {
            throw new \App\Exceptions\InvalidParamException("Câu hỏi không hợp lệ hoặc không thuộc về bài học này");
        }

        // Kiểm tra xem đáp án có đúng không
        $isCorrect = DB::table('options')
            ->where('option_id', $selectedOptionId)
            ->where('question_id', $questionId)
            ->where('is_correct', true)
            ->exists();

        // Tính điểm cho câu hỏi này
        $earnedScore = $isCorrect ? $question->score : 0;

        // Lấy thông tin về đáp án đã chọn và đáp án đúng
        $selectedOption = DB::table('options')
            ->where('option_id', $selectedOptionId)
            ->first();

        $correctOption = DB::table('options')
            ->where('question_id', $questionId)
            ->where('is_correct', true)
            ->first();

        // Lưu câu trả lời tạm thời vào cache thay vì session
        $answersKey = "user_{$userId}_lesson_{$lessonId}_answers";
        $currentAnswers = cache()->get($answersKey, []);
        $currentAnswers[$questionId] = $selectedOptionId;
        cache()->put($answersKey, $currentAnswers, 60 * 24); // Lưu trong 24 giờ

        // Trả về kết quả ngay lập tức
        return [
            'question_id' => $questionId,
            'question_text' => $question->question_text,
            'selected_option_id' => $selectedOptionId,
            'selected_option_text' => $selectedOption->option_text,
            'is_correct' => $isCorrect,
            'score' => $earnedScore,
            'explanation' => $question->explanation, // Luôn trả về giải thích, kể cả khi đúng
            'correct_option_id' => $isCorrect ? null : $correctOption->option_id,
            'correct_option_text' => $isCorrect ? null : $correctOption->option_text,
        ];
    }

    /**
     * Hoàn thành bài học sau khi đã trả lời các câu hỏi một cách riêng lẻ
     *
     * @param string $userId
     * @param int $lessonId
     * @return array Trả về kết quả tổng hợp của bài học
     */
    public function finalizeLessonProgress(string $userId, int $lessonId): array
    {
        // Lấy các câu trả lời đã lưu trong cache thay vì session
        $answersKey = "user_{$userId}_lesson_{$lessonId}_answers";
        $userAnswers = cache()->get($answersKey, []);

        if (empty($userAnswers)) {
            throw new \App\Exceptions\InvalidParamException("Không tìm thấy câu trả lời nào cho bài học này. Vui lòng trả lời ít nhất một câu hỏi trước khi hoàn thành bài học.");
        }

        // Sử dụng phương thức completeLesson hiện có để hoàn thành bài học
        $result = $this->completeLesson($userId, $lessonId, $userAnswers);

        // Xóa dữ liệu tạm trong cache sau khi hoàn thành
        cache()->forget($answersKey);

        return $result;
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