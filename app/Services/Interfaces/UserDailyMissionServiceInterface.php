<?php

namespace App\Services\Interfaces;

use Illuminate\Support\Collection;

interface UserDailyMissionServiceInterface
{
    public function generateDailyMissionsForUser(string $userId, ?string $date = null): Collection;
    public function getUserDailyMissions(string $userId, ?string $date = null): Collection;
    public function updateMissionProgress(string $userId, string $action, int $count = 1): void;
    public function claimMissionReward(string $userId, int $userMissionId): bool;
}