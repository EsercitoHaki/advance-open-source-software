<?php

namespace App\Repositories;

use App\Models\UserDailyMission;
use App\Repositories\Interfaces\UserDailyMissionRepositoryInterface;
use Illuminate\Support\Collection;

class UserDailyMissionRepository implements UserDailyMissionRepositoryInterface
{
    public function getUserMissionsByDate(string $userId, string $date): Collection
    {
        return UserDailyMission::with('mission')
            ->where('user_id', $userId)
            ->where('date', $date)
            ->get();
    }

    public function createUserDailyMission(string $userId, int $missionId, string $date): UserDailyMission
    {
        return UserDailyMission::create([
            'user_id' => $userId,
            'mission_id' => $missionId,
            'date' => $date,
            'progress' => 0,
            'is_completed' => false,
            'reward_claimed' => false
        ]);
    }

    public function updateProgress(int $userMissionId, int $progress, bool $isCompleted): bool
    {
        return UserDailyMission::where('user_mission_id', $userMissionId)
            ->update([
                'progress' => $progress,
                'is_completed' => $isCompleted
            ]);
    }

    public function claimReward(int $userMissionId): bool
    {
        return UserDailyMission::where('user_mission_id', $userMissionId)
            ->where('is_completed', true)
            ->where('reward_claimed', false)
            ->update(['reward_claimed' => true]);
    }
}