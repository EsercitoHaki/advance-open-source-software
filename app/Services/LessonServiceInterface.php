<?php

namespace App\Services;

use App\DTOs\LessonDTO;
use Illuminate\Support\Collection;

interface LessonServiceInterface
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
     * @return LessonDTO
     */
    public function getLessonById(string $lessonId): LessonDTO;

    /**
     * Lấy danh sách bài học theo danh mục.
     *
     * @param string $category
     * @return Collection
     */
    public function getLessonsByCategory(string $category): Collection;

    /**
     * Tạo bài học mới.
     *
     * @param array $lessonData
     * @return LessonDTO
     */
    public function createLesson(array $lessonData): LessonDTO;

    /**
     * Kiểm tra tồn tại của bài học
     *
     * @param string $lessonId
     * @return bool
     */
    public function checkLessonExists(string $lessonId): bool;
}