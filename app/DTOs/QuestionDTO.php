<?php

namespace App\DTOs;

use App\Models\Question;
use JsonSerializable;

class QuestionDTO implements JsonSerializable
{
    public function __construct(
        public ?int $questionId = null,
        public ?int $lessonId = null,
        public ?float $score = 1.00,
        public ?string $content = null,
        public ?string $questionText = null,
        public ?string $explanation = null
    ) {
    }

    /**
     * Tạo một đối tượng DTO từ model Question.
     */
    public static function fromModel(Question $question): self
    {
        return new self(
            questionId: $question->question_id,
            lessonId: $question->lesson_id,
            score: $question->score,
            content: $question->content,
            questionText: $question->question_text,
            explanation: $question->explanation
        );
    }

    /**
     * Chuyển đối tượng DTO thành mảng.
     */
    public function toArray(): array
    {
        return [
            'question_id' => $this->questionId,
            'lesson_id' => $this->lessonId,
            'score' => $this->score,
            'content' => $this->content,
            'question_text' => $this->questionText,
            'explanation' => $this->explanation
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