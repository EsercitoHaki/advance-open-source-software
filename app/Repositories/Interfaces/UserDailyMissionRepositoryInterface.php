<?php

namespace App\Repositories\Interfaces;

use App\Models\UserDailyMission;
use Illuminate\Support\Collection;

interface UserDailyMissionRepositoryInterface
{
    public function getUserMissionsByDate(string $userId, string $date): Collection;
    public function createUserDailyMission(string $userId, int $missionId, string $date): UserDailyMission;
    public function updateProgress(int $userMissionId, int $progress, bool $isCompleted): bool;
    public function claimReward(int $userMissionId): bool;
}