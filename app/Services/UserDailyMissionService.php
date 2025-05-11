<?php

namespace App\Services;

use App\DTOs\UserDailyMissionDTO;
use App\Repositories\Interfaces\MissionRepositoryInterface;
use App\Repositories\Interfaces\UserDailyMissionRepositoryInterface;
use App\Services\Interfaces\UserDailyMissionServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class UserDailyMissionService implements UserDailyMissionServiceInterface
{
    private MissionRepositoryInterface $missionRepository;
    private UserDailyMissionRepositoryInterface $userDailyMissionRepository;
    private const DAILY_MISSION_COUNT = 3;

    public function __construct(
        MissionRepositoryInterface $missionRepository,
        UserDailyMissionRepositoryInterface $userDailyMissionRepository
    ) {
        $this->missionRepository = $missionRepository;
        $this->userDailyMissionRepository = $userDailyMissionRepository;
    }

    public function generateDailyMissionsForUser(string $userId, ?string $date = null): Collection
    {
        $today = $date ?? Carbon::today()->toDateString();
        
        // Check if user already has missions for today
        $existingMissions = $this->userDailyMissionRepository->getUserMissionsByDate($userId, $today);
        
        if ($existingMissions->count() > 0) {
            // Return existing missions if already generated
            return $existingMissions->map(function ($mission) {
                return UserDailyMissionDTO::fromModel($mission);
            });
        }
        
        // Get random missions
        $randomMissions = $this->missionRepository->getRandomActiveMissions(self::DAILY_MISSION_COUNT);
        
        $userDailyMissions = collect();
        
        foreach ($randomMissions as $mission) {
            $userDailyMission = $this->userDailyMissionRepository->createUserDailyMission(
                $userId,
                $mission->mission_id,
                $today
            );
            
            // Manually set the mission relation to avoid additional queries
            $userDailyMission->setRelation('mission', $mission);
            
            $userDailyMissions->push(UserDailyMissionDTO::fromModel($userDailyMission));
        }
        
        return $userDailyMissions;
    }

    public function getUserDailyMissions(string $userId, ?string $date = null): Collection
    {
        $today = $date ?? Carbon::today()->toDateString();
        
        $missions = $this->userDailyMissionRepository->getUserMissionsByDate($userId, $today);
        
        // If no missions found for today, generate new ones
        if ($missions->isEmpty()) {
            return $this->generateDailyMissionsForUser($userId, $today);
        }
        
        return $missions->map(function ($mission) {
            return UserDailyMissionDTO::fromModel($mission);
        });
    }

    public function updateMissionProgress(string $userId, string $action, int $count = 1): void
    {
        $today = Carbon::today()->toDateString();
        
        // Get all missions for today
        $missions = $this->userDailyMissionRepository->getUserMissionsByDate($userId, $today);
        
        // Filter missions by action type
        $missionsToUpdate = $missions->filter(function ($mission) use ($action) {
            return $mission->mission->required_action === $action && !$mission->is_completed;
        });
        
        foreach ($missionsToUpdate as $mission) {
            $newProgress = $mission->progress + $count;
            $isCompleted = $newProgress >= $mission->mission->required_count;
            
            // Cap progress at required count
            if ($isCompleted) {
                $newProgress = $mission->mission->required_count;
            }
            
            $this->userDailyMissionRepository->updateProgress(
                $mission->user_mission_id,
                $newProgress,
                $isCompleted
            );
        }
    }

    public function claimMissionReward(string $userId, int $userMissionId): bool
    {
        return $this->userDailyMissionRepository->claimReward($userMissionId);
    }
}