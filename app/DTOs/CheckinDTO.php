<?php

namespace App\DTOs;

use App\Models\CheckIn;
use Illuminate\Http\Request;

class CheckInDTO
{
    public function __construct(
        public ?string $userId = null,
        public ?string $checkInDate = null,
        public ?int $coinsEarned = null
    ) {}

    /**
     * Tạo DTO từ Request (có thể là từ service hay controller gọi).
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            userId: $request->user()?->id,
            checkInDate: now()->toDateString(),
            coinsEarned: $request->get('coins_earned')
        );
    }

    /**
     * Tạo DTO từ Model CheckIn.
     */
    public static function fromModel(CheckIn $checkIn): self
    {
        return new self(
            userId: $checkIn->user_id,
            checkInDate: $checkIn->checkin_date,
            coinsEarned: $checkIn->coins_earned
        );
    }

    /**
     * Convert DTO to array.
     */
    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'checkin_date' => $this->checkInDate,
            'coins_earned' => $this->coinsEarned,
        ];
    }
}
