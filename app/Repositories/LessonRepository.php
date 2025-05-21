<?php

namespace App\Repositories;

use App\Models\Lesson;
use Illuminate\Support\Collection;
use App\Repositories\Interfaces\LessonRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LessonRepository implements LessonRepositoryInterface
{
    /**
     * Lấy danh sách tất cả bài học.
     *
     * @return Collection
     */
    public function getAllLessons(): Collection
    {
        try {
            return Lesson::orderBy('created_date', 'desc')->get();
        } catch (\Exception $e) {
            Log::error('Lỗi khi truy vấn tất cả bài học: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Lấy bài học theo ID.
     *
     * @param string $lessonId
     * @return Lesson|null
     */
    public function getLessonById(string $lessonId): ?Lesson
    {
        try {
            return Lesson::with('questions.options')
                ->where('lesson_id', $lessonId)
                ->first();
        } catch (\Exception $e) {
            Log::error('Lỗi khi truy vấn bài học theo ID: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Lấy danh sách bài học theo danh mục.
     *
     * @param string $category
     * @return Collection
     */
    public function getLessonsByCategory(string $category): Collection
    {
        try {
            return Lesson::where('category', $category)
                ->orderBy('created_date', 'desc')
                ->get();
        } catch (\Exception $e) {
            Log::error('Lỗi khi truy vấn bài học theo danh mục: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Tạo bài học mới.
     *
     * @param array $lessonData
     * @return Lesson
     */
    public function createLesson(array $lessonData): Lesson
    {
        try {
            DB::beginTransaction();

            // Đảm bảo có created_date
            if (!isset($lessonData['created_date'])) {
                $lessonData['created_date'] = Carbon::now()->format('Y-m-d H:i:s');
            }

            $lesson = Lesson::create($lessonData);

            DB::commit();
            return $lesson;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi khi tạo bài học mới: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Lấy số lượng bài học theo danh mục.
     *
     * @param string $category
     * @return int
     */
    public function countLessonsByCategory(string $category): int
    {
        try {
            return Lesson::where('category', $category)->count();
        } catch (\Exception $e) {
            Log::error('Lỗi khi đếm bài học theo danh mục: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateLesson(string $lessonId, array $lessonData): ?Lesson
    {
        try {
            DB::beginTransaction();
            $lesson = Lesson::find($lessonId);
            
            if ($lesson) {
                $lesson->update($lessonData);
                DB::commit();
                return $lesson;
            }
            
            DB::rollBack();
            return null;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi khi cập nhật bài học: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteLesson(string $lessonId): bool
    {
        try {
            DB::beginTransaction();
            $lesson = Lesson::find($lessonId);
            
            if ($lesson) {
                $lesson->delete();
                DB::commit();
                return true;
            }
            
            DB::rollBack();
            return false;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi khi xóa bài học: ' . $e->getMessage());
            throw $e;
        }
    }
}