<?php

namespace App\DTOs;

use App\Models\Question;
use JsonSerializable;

class QuestionDTO implements JsonSerializable
{
    public function __construct(
        public ?int $questionId = null,
        public ?int $lessonId = null,
        public ?string $questionText = null,
        public ?string $explanation = null,
        public ?string $audioFile = null,
        public ?string $audioUrl = null
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
            questionText: $question->question_text,
            explanation: $question->explanation,
            audioFile: $question->audio_file,
            audioUrl: $question->hasAudio() ? $question->getAudioUrl() : null,
            
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
            'question_text' => $this->questionText,
            'explanation' => $this->explanation,
            'audio_file' => $this->audioFile,
            'audio_url' => $this->audioUrl
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