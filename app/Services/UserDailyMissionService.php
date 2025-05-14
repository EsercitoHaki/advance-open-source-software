<?php

namespace App\Services;

use App\Models\Mission;
use App\Models\User;
use App\Models\UserDailyMission;
use App\DTOs\UserDailyMissionDTO;
use App\Repositories\Interfaces\UserDailyMissionRepositoryInterface;
use App\Services\Interfaces\UserDailyMissionServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserDailyMissionService implements UserDailyMissionServiceInterface
{
    private UserDailyMissionRepositoryInterface $repository;

    public function __construct(UserDailyMissionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getUserDailyMissions(string $userId): array
    {
        $today = Carbon::today()->toDateString();
        $missions = $this->repository->getUserMissionsByDate($userId, $today);
        
        if (count($missions) === 0) {
            $missions = $this->generateDailyMissions($userId);
        }
        
        return array_map(fn($mission) => UserDailyMissionDTO::fromModel($mission), $missions);
    }

    public function generateDailyMissions(string $userId): array
    {
        $today = Carbon::today()->toDateString();
        
        $randomMissions = Mission::where('is_active', true)
            ->inRandomOrder()
            ->limit(3)
            ->get();
            
        if ($randomMissions->count() === 0) {
            return [];
        }
        
        $userDailyMissions = [];
        
        DB::beginTransaction();
        try {
            foreach ($randomMissions as $mission) {
                $userDailyMission = $this->repository->create([
                    'user_id' => $userId,
                    'mission_id' => $mission->mission_id,
                    'date' => $today,
                    'progress' => 0,
                    'is_completed' => false,
                    'reward_claimed' => false
                ]);
                
                $userDailyMissions[] = $userDailyMission;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        
        return $userDailyMissions;
    }

    public function updateMissionProgress(string $userId, int $missionId, int $progressIncrement = 1): ?UserDailyMissionDTO
    {
        $today = Carbon::today()->toDateString();
        $userMission = $this->repository->getUserMissionByDateAndMission($userId, $missionId, $today);

        if (!$userMission || $userMission->is_completed) {
            return null;
        }

        $userMission->progress += $progressIncrement;

        if ($userMission->progress >= $userMission->mission->required_count) {
            $userMission->is_completed = true;
        }

        $userMission->save();

        return UserDailyMissionDTO::fromModel($userMission);
    }

    public function claimMissionReward(string $userId, int $userMissionId): ?UserDailyMissionDTO
    {
        $userMission = $this->repository->getById($userMissionId);

        if (!$userMission || $userMission->user_id !== $userId || Carbon::parse($userMission->date)->toDateString() !== Carbon::today()->toDateString()) {
            return null;
        }

        if (!$userMission->is_completed || $userMission->reward_claimed) {
            return null;
        }

        $user = User::find($userId);
        if (!$user) {
            return null;
        }

        $user->coins += $userMission->mission->reward_coins;
        $user->save();

        $userMission->reward_claimed = true;
        $userMission->save();

        return UserDailyMissionDTO::fromModel($userMission);
    }


    public function recordAction(string $userId, string $action): void
    {
        $today = Carbon::today()->toDateString();

        $missions = $this->repository->getUserMissionsByDate($userId, $today)
            ->filter(function ($userMission) use ($action) {
                return !$userMission->is_completed &&
                    $userMission->mission &&
                    $userMission->mission->required_action === $action &&
                    $userMission->progress < $userMission->mission->required_count;
            });

        foreach ($missions as $mission) {
            $mission->progress++;

            if ($mission->progress >= $mission->mission->required_count) {
                $mission->is_completed = true;
            }

            $mission->save();
        }
    }



}