<?php

namespace App\Repositories;

use App\Models\UserProgress;
use App\Repositories\Interfaces\UserProgressRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class UserProgressRepository extends BaseRepository implements UserProgressRepositoryInterface
{
    /**
     * UserProgressRepository constructor.
     *
     * @param UserProgress $model
     */
    public function __construct(UserProgress $model)
    {
        parent::__construct($model);
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
        try {
            return $this->model->where('user_id', $userId)
                ->where('lesson_id', $lessonId)
                ->first();
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
            return $this->model->where('user_id', $userId)
                ->with('lesson')  // Eager loading bài học để tối ưu truy vấn
                ->orderBy('start_date', 'desc')
                ->get();
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy tất cả tiến độ học tập: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Bắt đầu một bài học (ghi nhận thời gian bắt đầu)
     *
     * @param string $userId
     * @param int $lessonId
     * @return UserProgress
     */
    public function startLesson(string $userId, int $lessonId): UserProgress
    {
        try {
            DB::beginTransaction();

            $progress = $this->getUserProgress($userId, $lessonId);
            $now = Carbon::now();

            if (!$progress) {
                $progress = $this->model->create([
                    'user_id' => $userId,
                    'lesson_id' => $lessonId,
                    'completion_status' => 'In Progress',
                    'start_date' => $now,
                    'score' => 0
                ]);
            } elseif ($progress->completion_status === 'Not Started') {
                $progress->update([
                    'completion_status' => 'In Progress',
                    'start_date' => $now
                ]);
            }

            DB::commit();
            return $progress;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi khi bắt đầu bài học: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Cập nhật điểm số và trạng thái hoàn thành bài học
     *
     * @param string $userId
     * @param int $lessonId
     * @param float $score
     * @param bool $completed
     * @return UserProgress
     */
    public function updateProgress(string $userId, int $lessonId, float $score, bool $completed = false): UserProgress
    {
        try {
            DB::beginTransaction();

            $progress = $this->getUserProgress($userId, $lessonId);
            $now = Carbon::now();

            $data = [
                'score' => $score
            ];

            if ($completed) {
                $data['completion_status'] = 'Completed';
                $data['completion_date'] = $now;
            }

            if ($progress) {
                $progress->update($data);
            } else {
                $data['user_id'] = $userId;
                $data['lesson_id'] = $lessonId;
                $data['start_date'] = $now;

                if (!isset($data['completion_status'])) {
                    $data['completion_status'] = 'In Progress';
                }

                $progress = $this->model->create($data);
            }

            DB::commit();
            return $progress;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi khi cập nhật tiến độ bài học: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Lấy thống kê học tập của người dùng (tổng số bài học, số bài hoàn thành, điểm trung bình)
     *
     * @param string $userId
     * @return array
     */
    public function getUserLearningStats(string $userId): array
    {
        try {
            // Sử dụng một truy vấn duy nhất để tối ưu hiệu suất
            $stats = [
                'total_lessons' => 0,
                'completed_lessons' => 0,
                'average_score' => 0
            ];

            // Lấy tổng số bài học đã bắt đầu
            $totalLessons = $this->model->where('user_id', $userId)->count();
            $stats['total_lessons'] = $totalLessons;

            // Nếu có bài học thì mới tính các thống kê khác
            if ($totalLessons > 0) {
                // Lấy số bài học đã hoàn thành
                $completedLessons = $this->model->where('user_id', $userId)
                    ->where('completion_status', 'Completed')
                    ->count();
                $stats['completed_lessons'] = $completedLessons;

                // Tính điểm trung bình nếu có bài học đã hoàn thành
                if ($completedLessons > 0) {
                    $averageScore = $this->model->where('user_id', $userId)
                        ->where('completion_status', 'Completed')
                        ->avg('score');
                    $stats['average_score'] = round($averageScore, 2);
                }
            }

            return $stats;
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy thống kê học tập: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Lấy danh sách các bài học người dùng đã hoàn thành
     *
     * @param string $userId
     * @return Collection
     */
    public function getCompletedLessons(string $userId): Collection
    {
        try {
            return $this->model->where('user_id', $userId)
                ->where('completion_status', 'Completed')
                ->with('lesson')  // Eager loading bài học
                ->orderBy('completion_date', 'desc')
                ->get();
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy danh sách bài học đã hoàn thành: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Lấy danh sách các bài học người dùng đang học dở
     *
     * @param string $userId
     * @return Collection
     */
    public function getInProgressLessons(string $userId): Collection
    {
        try {
            return $this->model->where('user_id', $userId)
                ->where('completion_status', 'In Progress')
                ->with('lesson')  // Eager loading bài học
                ->orderBy('start_date', 'desc')
                ->get();
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy danh sách bài học đang học: ' . $e->getMessage());
            throw $e;
        }
    }
}