<?php

namespace App\Console\Commands;

use App\Services\Interfaces\StreakServiceInterface;
use Illuminate\Console\Command;

class CheckStreaks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-streaks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and reset streaks for users who haven\'t completed a lesson today';

    /**
     * The streak service.
     *
     * @var StreakServiceInterface
     */
    protected $streakService;

    /**
     * Create a new command instance.
     *
     * @param StreakServiceInterface $streakService
     */
    public function __construct(StreakServiceInterface $streakService)
    {
        parent::__construct();
        $this->streakService = $streakService;
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Checking streaks...');

        try {
            $this->streakService->checkAndResetStreaks();
            $this->info('Streak check completed successfully!');
        } catch (\Exception $e) {
            $this->error('Error checking streaks: ' . $e->getMessage());
        }
    }
}
