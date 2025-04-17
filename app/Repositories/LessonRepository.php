<?php

namespace App\Repositories;

use App\Models\Lesson;
use Illuminate\Support\Collection;
use App\Repositories\LessonRepositoryInterface;
use Carbon\Carbon;

class LessonRepository implements LessonRepositoryInterface
{
    /**
     * Lấy danh sách tất cả bài học.
     *
     * @return Collection
     */
    public function getAllLessons(): Collection
    {
        return Lesson::all();
    }

    /**
     * Lấy bài học theo ID.
     *
     * @param string $lessonId
     * @return Lesson|null
     */
    public function getLessonById(string $lessonId): ?Lesson
    {
        return Lesson::find($lessonId);
    }

    /**
     * Lấy danh sách bài học theo category.
     *
     * @param string $category
     * @return Collection
     */
    public function getLessonsByCategory(string $category): Collection
    {
        return Lesson::where('category', $category)->get();
    }

    /**
     * Tạo bài học mới.
     *
     * @param array $lessonData
     * @return Lesson
     */
    public function createLesson(array $lessonData): Lesson
    {
        return Lesson::create($lessonData);
    }
}