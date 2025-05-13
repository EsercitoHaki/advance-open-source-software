<?php

namespace App\Repositories\Interfaces;

use App\Models\UserDailyMission;

interface UserDailyMissionRepositoryInterface
{
    public function getAll(): array;
    public function getById(int $id): ?UserDailyMission;
    public function create(array $data): UserDailyMission;
    public function update(int $id, array $data): ?UserDailyMission;
    public function delete(int $id): void;
    public function getUserMissionsByDate(string $userId, string $date): array;
    public function getUserMissionByDateAndMission(string $userId, int $missionId, string $date): ?UserDailyMission;
}