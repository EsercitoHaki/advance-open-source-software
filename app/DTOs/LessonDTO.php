<?php

namespace App\DTOs;

use App\Models\Lesson;
use JsonSerializable;

class LessonDTO implements JsonSerializable
{
    public function __construct(
        public ?string $lessonId = null,
        public ?string $title = null,
        public ?string $category = null,
        public ?string $createdDate = null
    ) {
    }

    /**
     * Tạo một đối tượng DTO từ model Lesson.
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
     * Giúp Laravel tự json_encode đúng cách mà không lỗi encoding.
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
