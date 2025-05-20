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
    public ?MissionDTO $mission;

    public function __construct(
        int $user_mission_id,
        string $user_id,
        int $mission_id,
        string $date,
        int $progress,
        bool $is_completed,
        bool $reward_claimed,
        ?MissionDTO $mission = null
    ) {
        $this->user_mission_id = $user_mission_id;
        $this->user_id = $user_id;
        $this->mission_id = $mission_id;
        $this->date = $date;
        $this->progress = $progress;
        $this->is_completed = $is_completed;
        $this->reward_claimed = $reward_claimed;
        $this->mission = $mission;
    }

    public static function fromModel(UserDailyMission $userMission): self
    {
        $missionDTO = null;
        if ($userMission->mission) {
            $missionDTO = MissionDTO::fromModel($userMission->mission);
        }

        return new self(
            $userMission->user_mission_id,
            $userMission->user_id,
            $userMission->mission_id,
            $userMission->date,
            $userMission->progress,
            $userMission->is_completed,
            $userMission->reward_claimed,
            $missionDTO
        );
    }
}