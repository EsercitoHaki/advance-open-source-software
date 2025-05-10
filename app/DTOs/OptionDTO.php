<?php

namespace App\DTOs;

class OptionDTO
{
    public function __construct(
        public readonly ?int $option_id,
        public readonly int $question_id,
        public readonly string $option_text,
        public readonly bool $is_correct
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            option_id: $data['option_id'] ?? null,
            question_id: $data['question_id'],
            option_text: $data['option_text'],
            is_correct: $data['is_correct'] ?? false
        );
    }

    public function toArray(): array
    {
        return [
            'option_id' => $this->option_id,
            'question_id' => $this->question_id,
            'option_text' => $this->option_text,
            'is_correct' => $this->is_correct
        ];
    }
}