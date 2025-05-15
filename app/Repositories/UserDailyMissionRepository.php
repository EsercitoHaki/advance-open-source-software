<?php

namespace App\Repositories;

use App\Models\UserDailyMission;
use App\Repositories\Interfaces\UserDailyMissionRepositoryInterface;

class UserDailyMissionRepository implements UserDailyMissionRepositoryInterface
{
    public function getAll(): array
    {
        return UserDailyMission::all()->all();
    }

    public function getById(int $id): ?UserDailyMission
    {
        return UserDailyMission::find($id);
    }

    public function create(array $data): UserDailyMission
    {
        return UserDailyMission::create($data);
    }

    public function update(int $id, array $data): ?UserDailyMission
    {
        $userMission = UserDailyMission::find($id);
        
        if (!$userMission) {
            return null;
        }
        
        $userMission->update($data);
        return $userMission;
    }

    public function delete(int $id): void
    {
        $userMission = UserDailyMission::find($id);
        
        if ($userMission) {
            $userMission->delete();
        }
    }

    public function getUserMissionsByDate(string $userId, string $date): array
    {
        return UserDailyMission::where('user_id', $userId)
            ->where('date', $date)
            ->with('mission')
            ->get()
            ->all();
    }

    public function getUserMissionByDateAndMission(string $userId, int $missionId, string $date): ?UserDailyMission
    {
        return UserDailyMission::where('user_id', $userId)
            ->where('mission_id', $missionId)
            ->where('date', $date)
            ->with('mission')
            ->first();
    }

    public function createMany(array $data): void
    {
        UserDailyMission::insert($data);
    }
}