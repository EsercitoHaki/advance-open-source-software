<?php

namespace App\Services;

use App\DTOs\LessonDTO;
use App\Repositories\Interfaces\LessonRepositoryInterface;
use App\Services\Interfaces\LessonServiceInterface;
use Illuminate\Support\Collection;
use App\Exceptions\DataNotFoundException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LessonService implements LessonServiceInterface
{
    /**
     * @var LessonRepositoryInterface
     */
    protected $lessonRepository;

    /**
     * Khởi tạo service với repository cần thiết
     *
     * @param LessonRepositoryInterface $lessonRepository
     */
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
        try {
            $lessons = $this->lessonRepository->getAllLessons();
            return $lessons->map(function ($lesson) {
                return LessonDTO::fromModel($lesson);
            });
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy danh sách bài học: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Lấy bài học theo ID.
     *
     * @param string $lessonId
     * @return LessonDTO
     * @throws DataNotFoundException
     */
    public function getLessonById(string $lessonId): LessonDTO
    {
        try {
            $lesson = $this->lessonRepository->getLessonById($lessonId);

            if (!$lesson) {
                throw new DataNotFoundException('Không tìm thấy bài học');
            }

            return LessonDTO::fromModel($lesson);
        } catch (DataNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy thông tin bài học: ' . $e->getMessage());
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
            $lessons = $this->lessonRepository->getLessonsByCategory($category);

            return $lessons->map(function ($lesson) {
                return LessonDTO::fromModel($lesson);
            });
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy danh sách bài học theo danh mục: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Tạo bài học mới.
     *
     * @param array $lessonData
     * @return LessonDTO
     */
    public function createLesson(array $lessonData): LessonDTO
    {
        try {
            // Thêm ngày tạo nếu chưa có
            if (!isset($lessonData['created_date'])) {
                $lessonData['created_date'] = Carbon::now()->format('Y-m-d H:i:s');
            }

            $lesson = $this->lessonRepository->createLesson($lessonData);
            return LessonDTO::fromModel($lesson);
        } catch (\Exception $e) {
            Log::error('Lỗi khi tạo bài học mới: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Kiểm tra tồn tại của bài học
     *
     * @param string $lessonId
     * @return bool
     */
    public function checkLessonExists(string $lessonId): bool
    {
        try {
            $lesson = $this->lessonRepository->getLessonById($lessonId);
            return !is_null($lesson);
        } catch (\Exception $e) {
            Log::error('Lỗi khi kiểm tra tồn tại của bài học: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Chuyển từ collection sang mảng DTOs
     *
     * @param Collection $collection
     * @return Collection
     */
    protected function mapCollectionToDTO(Collection $collection): Collection
    {
        return $collection->map(function ($item) {
            return LessonDTO::fromModel($item);
        });
    }
}