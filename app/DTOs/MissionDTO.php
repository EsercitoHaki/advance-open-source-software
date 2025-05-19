<?php

namespace App\DTOs;
use App\Models\Mission;

class MissionDTO
{
    public int $mission_id;
    public string $title;
    public string $description;
    public int $reward_coins;
    public string $required_action;
    public int $required_count;
    public bool $is_active;

    public function __construct(
        int $mission_id,
        string $title,
        string $description,
        int $reward_coins,
        string $required_action,
        int $required_count,
        bool $is_active
    ) {
        $this->mission_id = $mission_id;
        $this->title = $title;
        $this->description = $description;
        $this->reward_coins = $reward_coins;
        $this->required_action = $required_action;
        $this->required_count = $required_count;
        $this->is_active = $is_active;
    }

    public static function fromModel(Mission $mission): self
    {
        return new self(
            $mission->mission_id,
            $mission->title,
            $mission->description,
            $mission->reward_coins,
            $mission->required_action,
            $mission->required_count,
            $mission->is_active
        );
    }
}
