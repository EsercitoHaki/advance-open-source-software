<?php

namespace App\Services\Interfaces;

use App\DTOs\UserDailyMissionDTO;

interface UserDailyMissionServiceInterface
{
    public function getUserDailyMissions(string $userId): array;
    public function generateDailyMissions(string $userId): array;
    public function updateMissionProgress(string $userId, int $missionId, int $progressIncrement): ?UserDailyMissionDTO;
    public function claimMissionReward(string $userId, int $userMissionId): ?UserDailyMissionDTO;
}