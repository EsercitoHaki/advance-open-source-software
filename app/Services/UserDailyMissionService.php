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
use Illuminate\Support\Facades\Log;

class UserDailyMissionService implements UserDailyMissionServiceInterface
{
    private UserDailyMissionRepositoryInterface $repository;

    public function __construct(UserDailyMissionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getUserDailyMissions(string $userId): array
    {
        try {
            $today = Carbon::today()->toDateString();
            $missions = $this->repository->getUserMissionsByDate($userId, $today);
            
            if (empty($missions)) {
                $missions = $this->generateDailyMissions($userId);
            }
            
            return array_map(fn($mission) => UserDailyMissionDTO::fromModel($mission), $missions);
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy nhiệm vụ hàng ngày: ' . $e->getMessage(), [
                'user_id' => $userId,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function generateDailyMissions(string $userId): array
    {
        $today = Carbon::today()->toDateString();
        $userDailyMissions = [];

        $existingMissions = $this->repository->getUserMissionsByDate($userId, $today);
        $existingActions = collect($existingMissions)->pluck('mission.required_action')->toArray();

        $availableMissions = Mission::query()
            ->where('is_active', true)
            ->whereNotIn('required_action', $existingActions)
            ->inRandomOrder()
            ->get(['mission_id', 'required_count', 'required_action', 'reward_coins']);

        $randomMissions = $availableMissions->unique('required_action')->take(3);

        if ($randomMissions->isEmpty()) {
            return [];
        }

        DB::beginTransaction();
        try {
            $missionData = [];
            foreach ($randomMissions as $mission) {
                $missionData[] = [
                    'user_id' => $userId,
                    'mission_id' => $mission->mission_id,
                    'date' => $today,
                    'progress' => 0,
                    'is_completed' => false,
                    'reward_claimed' => false,
                ];
            }

            $this->repository->createMany($missionData);

            $userDailyMissions = $this->repository->getUserMissionsByDate($userId, $today);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Lỗi khi tạo nhiệm vụ hàng ngày: ' . $e->getMessage(), [
                'user_id' => $userId,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }

        return $userDailyMissions;
    }


    public function updateMissionProgress(string $userId, int $missionId, int $progressIncrement = 1): ?UserDailyMissionDTO
    {
        try {
            DB::beginTransaction();
            
            $today = Carbon::today()->toDateString();
            $userMission = $this->repository->getUserMissionByDateAndMission($userId, $missionId, $today);

            if (!$userMission) {
            DB::rollback();
            throw new \Exception('Không tìm thấy nhiệm vụ tương ứng cho người dùng.');
            }

            if ($userMission->is_completed) {
                DB::rollback();
                throw new \Exception('Nhiệm vụ đã được hoàn thành.');
            }

            $userMission->progress += max(1, $progressIncrement);

            if ($userMission->progress >= $userMission->mission->required_count) {
                $userMission->is_completed = true;
                $userMission->progress = $userMission->mission->required_count;
            }

            $userMission->save();
            DB::commit();

            return UserDailyMissionDTO::fromModel($userMission);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Lỗi khi cập nhật tiến độ nhiệm vụ: ' . $e->getMessage(), [
                'user_id' => $userId,
                'mission_id' => $missionId,
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    public function claimMissionReward(string $userId, int $userMissionId): ?UserDailyMissionDTO
    {
        try {
            DB::beginTransaction();
            
            $userMission = $this->repository->getById($userMissionId, ['mission']);

            if (!$userMission) {
                DB::rollback();
                throw new \Exception('Không tìm thấy nhiệm vụ.');
            }

            if ($userMission->user_id !== $userId) {
                DB::rollback();
                throw new \Exception('Không thể nhận phần thưởng cho nhiệm vụ không thuộc về bạn hoặc không phải hôm nay.');
            }

            if (!$userMission->is_completed) {
                DB::rollback();
                throw new \Exception('Nhiệm vụ chưa được hoàn thành.');
            }

            if ($userMission->reward_claimed) {
                DB::rollback();
                throw new \Exception('Phần thưởng đã được nhận.');
            }

            $user = User::lockForUpdate()->find($userId);
            if (!$user) {
                DB::rollback();
                throw new \Exception('Không tìm thấy người dùng.');
            }

            $user->coins += $userMission->mission->reward_coins;
            $user->save();

            $userMission->reward_claimed = true;
            $userMission->save();

            DB::commit();
            return UserDailyMissionDTO::fromModel($userMission);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Lỗi khi nhận phần thưởng nhiệm vụ: ' . $e->getMessage(), [
                'user_id' => $userId,
                'user_mission_id' => $userMissionId,
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }


    public function recordAction(string $userId, string $action): void
    {
        try {
            $today = Carbon::today()->toDateString();
            
            $affectedMissions = $this->repository->getUserMissionsForAction($userId, $today, $action);
            
            if (empty($affectedMissions)) {
                return;
            }
            
            DB::beginTransaction();
            
            foreach ($affectedMissions as $mission) {
                $mission->progress = min($mission->progress + 1, $mission->mission->required_count);

                if ($mission->progress >= $mission->mission->required_count) {
                    $mission->is_completed = true;
                    $mission->progress = $mission->mission->required_count;

                    // NotificationService::sendMissionCompleted($userId, $mission->mission_id);
                }

                $mission->save();
            }
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Lỗi khi ghi nhận hành động người dùng: ' . $e->getMessage(), [
                'user_id' => $userId,
                'action' => $action,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function completeMission(string $userId, int $missionId): ?UserDailyMissionDTO
    {
        try {
            DB::beginTransaction();
            
            $today = Carbon::today()->toDateString();
            $userMission = $this->repository->getUserMissionByDateAndMission($userId, $missionId, $today);

            if (!$userMission) {
                DB::rollback();
                throw new \Exception('Không tìm thấy nhiệm vụ.');
            }

            if ($userMission->is_completed) {
                DB::rollback();
                throw new \Exception('Nhiệm vụ đã hoàn thành.');
            }

            $userMission->progress = $userMission->mission->required_count;
            $userMission->is_completed = true;
            $userMission->save();
            
            DB::commit();
            
            return UserDailyMissionDTO::fromModel($userMission);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Lỗi khi hoàn thành nhiệm vụ: ' . $e->getMessage(), [
                'user_id' => $userId,
                'mission_id' => $missionId,
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

}