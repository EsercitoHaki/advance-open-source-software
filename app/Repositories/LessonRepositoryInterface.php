<?php

namespace App\Repositories;

use App\Models\Lesson;
use Illuminate\Support\Collection;

interface LessonRepositoryInterface
{
    /**
     * Lấy danh sách tất cả bài học.
     *
     * @return Collection
     */
    public function getAllLessons(): Collection;

    /**
     * Lấy bài học theo ID.
     *
     * @param string $lessonId
     * @return Lesson|null
     */
    public function getLessonById(string $lessonId): ?Lesson;

    /**
     * Lấy danh sách bài học theo category.
     *
     * @param string $category
     * @return Collection
     */
    public function getLessonsByCategory(string $category): Collection;

    /**
     * Tạo bài học mới.
     *
     * @param array $lessonData
     * @return Lesson
     */
    public function createLesson(array $lessonData): Lesson;
}