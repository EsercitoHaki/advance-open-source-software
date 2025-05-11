<?php

namespace App\DTOs;

use App\Models\UserDailyMission;

class UserDailyMissionDTO
{
    public int $user_mission_id;
    public string $user_id;
    public int $mission_id;
    public string $date;
    public int $progress;
    public bool $is_completed;
    public bool $reward_claimed;
    public ?MissionDTO $mission = null;

    public function __construct(
        int $user_mission_id,
        string $user_id,
        int $mission_id,
        string $date,
        int $progress,
        bool $is_completed,
        bool $reward_claimed
    ) {
        $this->user_mission_id = $user_mission_id;
        $this->user_id = $user_id;
        $this->mission_id = $mission_id;
        $this->date = $date;
        $this->progress = $progress;
        $this->is_completed = $is_completed;
        $this->reward_claimed = $reward_claimed;
    }

    public static function fromModel(UserDailyMission $userDailyMission): self
    {
        $dto = new self(
            $userDailyMission->user_mission_id,
            $userDailyMission->user_id,
            $userDailyMission->mission_id,
            $userDailyMission->date,
            $userDailyMission->progress,
            $userDailyMission->is_completed,
            $userDailyMission->reward_claimed
        );

        if ($userDailyMission->relationLoaded('mission')) {
            $dto->mission = MissionDTO::fromModel($userDailyMission->mission);
        }

        return $dto;
    }
}