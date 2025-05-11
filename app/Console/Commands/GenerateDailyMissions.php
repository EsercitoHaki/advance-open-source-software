<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\Interfaces\UserDailyMissionServiceInterface;
use Illuminate\Console\Command;

class GenerateDailyMissions extends Command
{
    protected $signature = 'missions:generate-daily';
    protected $description = 'Generate daily missions for all users';

    private UserDailyMissionServiceInterface $dailyMissionService;

    public function __construct(UserDailyMissionServiceInterface $dailyMissionService)
    {
        parent::__construct();
        $this->dailyMissionService = $dailyMissionService;
    }

    public function handle()
    {
        $this->info('Starting to generate daily missions for all users...');
        
        // Get all users
        $users = User::select('user_id')->get();
        $count = 0;
        
        foreach ($users as $user) {
            $this->dailyMissionService->generateDailyMissionsForUser($user->user_id);
            $count++;
            
            if ($count % 100 === 0) {
                $this->info("Processed $count users");
            }
        }
        
        $this->info("Daily missions generated for $count users successfully!");
        
        return 0;
    }
}
