<?php

namespace App\Repositories;

use App\Models\UserProgress;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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
        return $this->model->where('user_id', $userId)
            ->where('lesson_id', $lessonId)
            ->first();
    }

    /**
     * Lấy tất cả tiến độ học tập của một người dùng
     *
     * @param string $userId
     * @return Collection
     */
    public function getAllUserProgress(string $userId): Collection
    {
        return $this->model->where('user_id', $userId)
            ->get();
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
        $progress = $this->getUserProgress($userId, $lessonId);

        if (!$progress) {
            $progress = $this->model->create([
                'user_id' => $userId,
                'lesson_id' => $lessonId,
                'completion_status' => 'In Progress',
                'start_date' => now()
            ]);
        } elseif ($progress->completion_status === 'Not Started') {
            $progress->update([
                'completion_status' => 'In Progress',
                'start_date' => now()
            ]);
        }

        return $progress;
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
        $progress = $this->getUserProgress($userId, $lessonId);

        $data = [
            'score' => $score
        ];

        if ($completed) {
            $data['completion_status'] = 'Completed';
            $data['completion_date'] = now();
        }

        if ($progress) {
            $progress->update($data);
        } else {
            $data['user_id'] = $userId;
            $data['lesson_id'] = $lessonId;
            $data['start_date'] = now();

            if (!isset($data['completion_status'])) {
                $data['completion_status'] = 'In Progress';
            }

            $progress = $this->model->create($data);
        }

        return $progress;
    }

    /**
     * Lấy thống kê học tập của người dùng (tổng số bài học, số bài hoàn thành, điểm trung bình)
     *
     * @param string $userId
     * @return array
     */
    public function getUserLearningStats(string $userId): array
    {
        $totalLessons = $this->model->where('user_id', $userId)->count();
        $completedLessons = $this->model->where('user_id', $userId)
            ->where('completion_status', 'Completed')
            ->count();
        $averageScore = $this->model->where('user_id', $userId)
            ->where('completion_status', 'Completed')
            ->avg('score');

        return [
            'total_lessons' => $totalLessons,
            'completed_lessons' => $completedLessons,
            'average_score' => $averageScore ?? 0
        ];
    }
}