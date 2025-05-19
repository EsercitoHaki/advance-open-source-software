<?php

namespace App\Services;

use App\DTOs\UserStatsDTO;
use App\Exceptions\DataNotFoundException;
use App\Exceptions\InvalidParamException;
use App\Models\UserProgress;
use App\Repositories\Interfaces\QuestionRepositoryInterface;
use App\Repositories\Interfaces\UserProgressRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\UserProgressServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * UserProgressService constructor.
     *
     * @param UserProgressRepositoryInterface $userProgressRepository
     * @param QuestionRepositoryInterface $questionRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        UserProgressRepositoryInterface $userProgressRepository,
        QuestionRepositoryInterface $questionRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->userProgressRepository = $userProgressRepository;
        $this->questionRepository = $questionRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Lấy tiến độ học tập của người dùng cho một bài học cụ thể
     *
     * @param string $userId
     * @param int $lessonId
     * @return UserProgress|null
     * @throws DataNotFoundException
     */
    public function getUserProgress(string $userId, int $lessonId): ?UserProgress
    {
        try {
            $progress = $this->userProgressRepository->getUserProgress($userId, $lessonId);

            if (!$progress) {
                throw new DataNotFoundException('Không tìm thấy tiến độ học tập cho bài học này');
            }

            return $progress;
        } catch (DataNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy tiến độ học tập: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Lấy tất cả tiến độ học tập của một người dùng
     *
     * @param string $userId
     * @return Collection
     */
    public function getAllUserProgress(string $userId): Collection
    {
        try {
            return $this->userProgressRepository->getAllUserProgress($userId);
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy tất cả tiến độ học tập: ' . $e->getMessage());
            throw $e;
        }
    }    /**
         * Bắt đầu một bài học
         *
         * @param string $userId
         * @param int $lessonId
         * @return UserProgress
         * @throws InvalidParamException
         */
    public function startLesson(string $userId, int $lessonId): UserProgress
    {
        try {
            // Kiểm tra số mạng của người dùng trước khi cho phép bắt đầu bài học
            $user = $this->userRepository->getUserById($userId);
            if (!$user) {
                throw new DataNotFoundException('Không tìm thấy người dùng');
            }

            $lives = $user->lives ?? 5; // Mặc định là 5 nếu không có
            if ($lives <= 0) {
                throw new InvalidParamException('Bạn đã hết mạng. Vui lòng đợi để mạng được phục hồi hoặc mua thêm mạng để tiếp tục học.');
            }

            // Lấy thông tin bài học
            $lesson = DB::table('lessons')->where('lesson_id', $lessonId)->first();
            if (!$lesson) {
                throw new DataNotFoundException('Không tìm thấy bài học');
            }

            $progress = $this->userProgressRepository->startLesson($userId, $lessonId);

            // Trả về thêm thông tin về thời gian giới hạn
            $progress->time_limit = $lesson->time_limit ?? 600; // Mặc định 10 phút nếu không có

            return $progress;
        } catch (DataNotFoundException $e) {
            throw $e;
        } catch (InvalidParamException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Lỗi khi bắt đầu bài học: ' . $e->getMessage());
            throw $e;
        }
    }    /**
         * Tính điểm và cập nhật tiến độ học tập khi người dùng hoàn thành bài học
         *
         * @param string $userId
         * @param int $lessonId
         * @param array $userAnswers [questionId => optionId]
         * @param int $elapsedTime Thời gian đã sử dụng (tính bằng giây)
         * @return array Trả về kết quả bao gồm điểm số và thông tin câu trả lời
         * @throws InvalidParamException
         */
    public function completeLesson(string $userId, int $lessonId, array $userAnswers, int $elapsedTime = 0): array
    {
        if (empty($userAnswers)) {
            throw new InvalidParamException('Danh sách câu trả lời không được để trống');
        }

        // Kiểm tra thời gian của bài học
        $lesson = DB::table('lessons')->where('lesson_id', $lessonId)->first();
        if (!$lesson) {
            throw new DataNotFoundException('Không tìm thấy bài học');
        }

        $timeLimit = $lesson->time_limit ?? 600; // Mặc định 10 phút
        if ($elapsedTime > $timeLimit) {
            throw new InvalidParamException('Thời gian làm bài đã hết. Bài làm của bạn không được ghi nhận.');
        }

        try {
            // Bắt đầu transaction để đảm bảo tính nhất quán của dữ liệu
            return DB::transaction(function () use ($userId, $lessonId, $userAnswers) {
                // Lấy tất cả câu hỏi của bài học
                $questions = $this->questionRepository->getQuestionsByLessonId($lessonId);

                if ($questions->isEmpty()) {
                    throw new DataNotFoundException('Không tìm thấy câu hỏi nào cho bài học này');
                }

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

                    // Kiểm tra xem đáp án có đúng không - sử dụng eager loading để tối ưu truy vấn
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

                    if (!$selectedOption) {
                        throw new DataNotFoundException('Không tìm thấy đáp án đã chọn');
                    }

                    if (!$correctOption) {
                        throw new DataNotFoundException('Không tìm thấy đáp án đúng cho câu hỏi');
                    }

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
                }                // Cập nhật tiến độ học tập
                $finalScore = $maxScore > 0 ? ($totalScore / $maxScore) * 100 : 0;
                $userProgress = $this->userProgressRepository->updateProgress(
                    $userId,
                    $lessonId,
                    $finalScore,
                    true,
                    $elapsedTime // Lưu lại thời gian đã sử dụng
                );

                // Trả về kết quả
                return [
                    'total_score' => $finalScore,
                    'max_score' => 100,
                    'passed' => $finalScore >= 50, // Giả định rằng điểm đậu là 70%
                    'question_results' => $results,
                    'progress_status' => $userProgress->completion_status
                ];
            });
        } catch (DataNotFoundException $e) {
            Log::error('Lỗi khi hoàn thành bài học - không tìm thấy dữ liệu: ' . $e->getMessage());
            throw $e;
        } catch (\Exception $e) {
            Log::error('Lỗi khi hoàn thành bài học: ' . $e->getMessage());
            throw $e;
        }
    }    /**
         * Xử lý việc nộp từng câu trả lời một và trả về phản hồi ngay lập tức
         *
         * @param string $userId
         * @param int $lessonId
         * @param int $questionId
         * @param int $selectedOptionId
         * @param int $elapsedTime Thời gian đã sử dụng (tính bằng giây)
         * @return array Trả về kết quả bao gồm thông tin câu trả lời và giải thích nếu sai
         * @throws InvalidParamException
         * @throws DataNotFoundException
         */
    public function submitSingleAnswer(string $userId, int $lessonId, int $questionId, int $selectedOptionId, int $elapsedTime = 0): array
    {
        try {
            // Kiểm tra thời gian của bài học
            $lesson = DB::table('lessons')->where('lesson_id', $lessonId)->first();
            if (!$lesson) {
                throw new DataNotFoundException('Không tìm thấy bài học');
            }

            $timeLimit = $lesson->time_limit ?? 600; // Mặc định 10 phút
            if ($elapsedTime > $timeLimit) {
                throw new InvalidParamException('Thời gian làm bài đã hết. Bài làm của bạn không được ghi nhận.');
            }

            // Cập nhật thời gian đã sử dụng cho tiến độ học tập
            $userProgress = $this->userProgressRepository->getUserProgress($userId, $lessonId);
            if ($userProgress) {
                $this->userProgressRepository->updateProgress($userId, $lessonId, $userProgress->score, false, $elapsedTime);
            }

            // Kiểm tra xem câu hỏi có thuộc về bài học không
            $question = $this->questionRepository->getQuestionById($questionId);

            if (!$question || $question->lesson_id != $lessonId) {
                throw new InvalidParamException('Câu hỏi không hợp lệ hoặc không thuộc về bài học này');
            }// Kiểm tra xem đáp án có đúng không
            $isCorrect = DB::table('options')
                ->where('option_id', $selectedOptionId)
                ->where('question_id', $questionId)
                ->where('is_correct', true)
                ->exists();

            // Tính điểm cho câu hỏi này
            $earnedScore = $isCorrect ? $question->score : 0;

            // Nếu câu trả lời sai, trừ 1 mạng của người dùng
            if (!$isCorrect) {
                $user = $this->userRepository->getUserById($userId);
                if ($user) {
                    $lives = $user->lives ?? 5; // Mặc định là 5 nếu không có
                    if ($lives > 0) {
                        $this->userRepository->updateStats($user, ['lives' => $lives - 1]);
                    }
                }
            }

            // Lấy thông tin về đáp án đã chọn và đáp án đúng
            $selectedOption = DB::table('options')
                ->where('option_id', $selectedOptionId)
                ->first();

            $correctOption = DB::table('options')
                ->where('question_id', $questionId)
                ->where('is_correct', true)
                ->first();

            if (!$selectedOption) {
                throw new DataNotFoundException('Không tìm thấy đáp án đã chọn');
            }

            if (!$correctOption) {
                throw new DataNotFoundException('Không tìm thấy đáp án đúng cho câu hỏi');
            }

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
        } catch (InvalidParamException $e) {
            throw $e;
        } catch (DataNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Lỗi khi nộp câu trả lời: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Hoàn thành bài học sau khi đã trả lời các câu hỏi một cách riêng lẻ
     *
     * @param string $userId
     * @param int $lessonId
     * @return array Trả về kết quả tổng hợp của bài học
     * @throws InvalidParamException
     */
    public function finalizeLessonProgress(string $userId, int $lessonId): array
    {
        try {
            // Lấy các câu trả lời đã lưu trong cache
            $answersKey = "user_{$userId}_lesson_{$lessonId}_answers";
            $userAnswers = cache()->get($answersKey, []);

            if (empty($userAnswers)) {
                throw new InvalidParamException('Không tìm thấy câu trả lời nào cho bài học này. Vui lòng trả lời ít nhất một câu hỏi trước khi hoàn thành bài học.');
            }

            // Sử dụng phương thức completeLesson hiện có để hoàn thành bài học
            $result = $this->completeLesson($userId, $lessonId, $userAnswers);

            // Xóa dữ liệu tạm trong cache sau khi hoàn thành
            cache()->forget($answersKey);

            return $result;
        } catch (InvalidParamException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Lỗi khi hoàn thành tiến độ bài học: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Lấy thống kê học tập của người dùng
     *
     * @param string $userId
     * @return array
     */
    public function getUserLearningStats(string $userId): array
    {
        try {
            // Lấy thông tin người dùng
            $user = $this->userRepository->getUserById($userId);
            if (!$user) {
                throw new DataNotFoundException('Không tìm thấy người dùng');
            }

            // Lấy thông tin học tập
            $learningStats = $this->userProgressRepository->getUserLearningStats($userId);

            // Tạo learningProgress object
            $learningProgress = [
                'completed_lessons' => $learningStats['completed_lessons'],
                'mastered_words' => 0,  // Placeholder hoặc dữ liệu từ nguồn khác nếu có
                'total_lessons' => $learningStats['total_lessons'],
                'average_score' => $learningStats['average_score']
            ];

            // Tạo DTO từ thông tin người dùng và dữ liệu học tập
            $statsDTO = new UserStatsDTO(
                $user->coins ?? 0,
                $user->lives ?? 5,
                $user->current_streak ?? 0,
                $user->longest_streak ?? 0,
                $learningProgress
            );

            return $statsDTO->toArray();
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy thống kê học tập: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Kiểm tra xem người dùng đã bắt đầu một bài học hay chưa
     *
     * @param string $userId
     * @param int $lessonId
     * @return bool
     */
    public function hasStartedLesson(string $userId, int $lessonId): bool
    {
        try {
            $progress = $this->userProgressRepository->getUserProgress($userId, $lessonId);
            return $progress !== null;
        } catch (\Exception $e) {
            Log::error('Lỗi khi kiểm tra tiến độ bài học: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Kiểm tra xem người dùng đã hoàn thành một bài học hay chưa
     *
     * @param string $userId
     * @param int $lessonId
     * @return bool
     */
    public function hasCompletedLesson(string $userId, int $lessonId): bool
    {
        try {
            $progress = $this->userProgressRepository->getUserProgress($userId, $lessonId);
            return $progress !== null && $progress->completion_status === 'Completed';
        } catch (\Exception $e) {
            Log::error('Lỗi khi kiểm tra hoàn thành bài học: ' . $e->getMessage());
            return false;
        }
    }
}