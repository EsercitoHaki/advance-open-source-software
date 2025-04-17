<?php

namespace App\Repositories;

use App\Models\Lesson;
use Illuminate\Support\Collection;
use App\Repositories\LessonRepositoryInterface;
use Carbon\Carbon;

class LessonRepository implements LessonRepositoryInterface
{
    /**
     * Dữ liệu mẫu cho bài học
     * 
     * @var array
     */
    protected $mockLessons = [];

    /**
     * Khởi tạo repository với dữ liệu mẫu
     */
    public function __construct()
    {
        $now = Carbon::now()->format('Y-m-d');

        // Tạo dữ liệu mẫu
        $this->mockLessons = [
            [
                'lesson_id' => '1',
                'title' => 'Introduction to Laravel',
                'category' => 'Grammar',
                'created_date' => $now,
            ],
            [
                'lesson_id' => '2',
                'title' => 'Laravel Controllers',
                'category' => 'Grammar',
                'created_date' => $now,
            ],
            [
                'lesson_id' => '3',
                'title' => 'Eloquent ORM Basics',
                'category' => 'Vocabulary',
                'created_date' => $now,
            ],
            [
                'lesson_id' => '4',
                'title' => 'Laravel Blade Templates',
                'category' => 'Reading',
                'created_date' => $now,
            ],
            [
                'lesson_id' => '5',
                'title' => 'Laravel Authentication',
                'category' => 'Listening',
                'created_date' => $now,
            ],
            [
                'lesson_id' => '6',
                'title' => 'Laravel Middleware',
                'category' => 'Grammar',
                'created_date' => $now,
            ],
            [
                'lesson_id' => '7',
                'title' => 'Laravel Migration & Seeding',
                'category' => 'Vocabulary',
                'created_date' => $now,
            ],
            [
                'lesson_id' => '8',
                'title' => 'Laravel API Development',
                'category' => 'Reading',
                'created_date' => $now,
            ],
            [
                'lesson_id' => '9',
                'title' => 'Laravel Validation',
                'category' => 'Listening',
                'created_date' => $now,
            ],
            [
                'lesson_id' => '10',
                'title' => 'Laravel Testing',
                'category' => 'Grammar',
                'created_date' => $now,
            ],
        ];
    }

    /**
     * Lấy danh sách tất cả bài học.
     *
     * @return Collection
     */
    public function getAllLessons(): Collection
    {
        // Uncomment dòng này khi đã có cơ sở dữ liệu
        // return Lesson::all();

        // Dùng dữ liệu mẫu
        return collect($this->mockLessons)->map(function ($lesson) {
            return $this->arrayToModel($lesson);
        });
    }

    /**
     * Lấy bài học theo ID.
     *
     * @param string $lessonId
     * @return Lesson|null
     */
    public function getLessonById(string $lessonId): ?Lesson
    {
        // Uncomment dòng này khi đã có cơ sở dữ liệu
        // return Lesson::find($lessonId);

        // Dùng dữ liệu mẫu
        $lesson = collect($this->mockLessons)->firstWhere('lesson_id', $lessonId);
        return $lesson ? $this->arrayToModel($lesson) : null;
    }

    /**
     * Lấy danh sách bài học theo category.
     *
     * @param string $category
     * @return Collection
     */
    public function getLessonsByCategory(string $category): Collection
    {
        // Uncomment dòng này khi đã có cơ sở dữ liệu
        // return Lesson::where('category', $category)->get();

        // Dùng dữ liệu mẫu
        return collect($this->mockLessons)
            ->where('category', $category)
            ->map(function ($lesson) {
                return $this->arrayToModel($lesson);
            });
    }

    /**
     * Tạo bài học mới.
     *
     * @param array $lessonData
     * @return Lesson
     */
    public function createLesson(array $lessonData): Lesson
    {
        // Uncomment dòng này khi đã có cơ sở dữ liệu
        // return Lesson::create($lessonData);

        // Dùng dữ liệu mẫu - Tạo một ID mới và thêm vào mảng dữ liệu mẫu
        $lessonId = count($this->mockLessons) + 1;
        $lessonData['lesson_id'] = (string) $lessonId;
        $this->mockLessons[] = $lessonData;

        return $this->arrayToModel($lessonData);
    }

    /**
     * Chuyển đổi mảng thành model Lesson
     *
     * @param array $data
     * @return Lesson
     */
    protected function arrayToModel(array $data): Lesson
    {
        $lesson = new Lesson();

        foreach ($data as $key => $value) {
            $lesson->$key = $value;
        }

        // Make the model not "new" so that it doesn't try to save to DB
        $lesson->exists = true;

        return $lesson;
    }
}