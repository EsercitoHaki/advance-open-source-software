<?php

namespace App\Services;

use App\DTOs\LessonDTO;
use App\Repositories\LessonRepositoryInterface;
use Illuminate\Support\Collection;
use App\Exceptions\DataNotFoundException;

class LessonService implements LessonServiceInterface
{
    protected $lessonRepository;

    public function __construct(LessonRepositoryInterface $lessonRepository)
    {
        $this->lessonRepository = $lessonRepository;
    }

    /**
     * Lấy danh sách tất cả bài học.
     *
     * @return Collection
     */
    public function getAllLessons(): Collection
    {
        $lessons = $this->lessonRepository->getAllLessons();
        return $lessons->map(function ($lesson) {
            return LessonDTO::fromModel($lesson);
        });
    }

    /**
     * Lấy bài học theo ID.
     *
     * @param string $lessonId
     * @return LessonDTO|null
     * @throws DataNotFoundException
     */
    public function getLessonById(string $lessonId): ?LessonDTO
    {
        $lesson = $this->lessonRepository->getLessonById($lessonId);

        if (!$lesson) {
            throw new DataNotFoundException('Không tìm thấy bài học');
        }

        return LessonDTO::fromModel($lesson);
    }

    /**
     * Lấy danh sách bài học theo category.
     *
     * @param string $category
     * @return Collection
     */
    public function getLessonsByCategory(string $category): Collection
    {
        $lessons = $this->lessonRepository->getLessonsByCategory($category);
        return $lessons->map(function ($lesson) {
            return LessonDTO::fromModel($lesson);
        });
    }

    /**
     * Tạo bài học mới.
     *
     * @param array $lessonData
     * @return LessonDTO
     */
    public function createLesson(array $lessonData): LessonDTO
    {
        $lesson = $this->lessonRepository->createLesson($lessonData);
        return LessonDTO::fromModel($lesson);
    }
}