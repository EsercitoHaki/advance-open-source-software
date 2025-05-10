<?php

namespace App\DTOs;

use App\Models\Lesson;
use JsonSerializable;

class LessonDTO implements JsonSerializable
{
    /**
     * Khởi tạo đối tượng DTO
     * 
     * @param string|null $lessonId ID của bài học
     * @param string|null $title Tiêu đề bài học
     * @param string|null $category Danh mục của bài học
     * @param string|null $createdDate Ngày tạo bài học
     */
    public function __construct(
        public ?string $lessonId = null,
        public ?string $title = null,
        public ?string $category = null,
        public ?string $createdDate = null
    ) {
    }

    /**
     * Tạo một đối tượng DTO từ model Lesson.
     * 
     * @param Lesson $lesson Model bài học
     * @return self
     */
    public static function fromModel(Lesson $lesson): self
    {
        return new self(
            lessonId: $lesson->lesson_id,
            title: $lesson->title,
            category: $lesson->category,
            createdDate: $lesson->created_date
        );
    }

    /**
     * Chuyển đối tượng DTO thành mảng.
     * 
     * @return array
     */
    public function toArray(): array
    {
        return [
            'lesson_id' => $this->lessonId,
            'title' => $this->title,
            'category' => $this->category,
            'created_date' => $this->createdDate
        ];
    }

    /**
     * Chuyển đổi đối tượng thành chuỗi JSON.
     * 
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * Giúp Laravel tự json_encode đúng cách mà không lỗi encoding.
     * 
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Chuyển đổi mảng dữ liệu thành đối tượng DTO.
     * 
     * @param array $data Mảng dữ liệu
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            lessonId: $data['lesson_id'] ?? null,
            title: $data['title'] ?? null,
            category: $data['category'] ?? null,
            createdDate: $data['created_date'] ?? null
        );
    }
}
