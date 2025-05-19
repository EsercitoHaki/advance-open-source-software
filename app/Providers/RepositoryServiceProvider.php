<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\AuthRepositoryInterface;
use App\Repositories\AuthRepository;
use App\Services\AuthServiceInterface;
use App\Services\AuthService;
use App\Repositories\Interfaces\LessonRepositoryInterface;
use App\Repositories\LessonRepository;
use App\Services\Interfaces\LessonServiceInterface;
use App\Services\LessonService;
use App\Repositories\Interfaces\QuestionRepositoryInterface;
use App\Repositories\QuestionRepository;
use App\Services\Interfaces\QuestionServiceInterface;
use App\Services\QuestionService;
use App\Repositories\Interfaces\UserProgressRepositoryInterface;
use App\Repositories\UserProgressRepository;
use App\Repositories\Interfaces\OptionRepositoryInterface;
use App\Repositories\OptionRepository;
use App\Services\Interfaces\OptionServiceInterface;
use App\Services\OptionService;
use App\Services\Interfaces\UserProgressServiceInterface;
use App\Services\UserProgressService;
use App\Repositories\Interfaces\FriendRepositoryInterface;
use App\Repositories\FriendRepository;
use App\Repositories\Interfaces\FriendRequestRepositoryInterface;
use App\Repositories\FriendRequestRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Services\FriendService;
use App\Repositories\Interfaces\MissionRepositoryInterface;
use App\Repositories\MissionRepository;
use App\Services\Interfaces\MissionServiceInterface;
use App\Services\MissionService;
use App\Repositories\Interfaces\UserDailyMissionRepositoryInterface;
use App\Repositories\UserDailyMissionRepository;
use App\Services\Interfaces\UserDailyMissionServiceInterface;
use App\Services\UserDailyMissionService;
use App\Repositories\CommentRepository;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Services\CommentService;
use App\Services\Interfaces\CommentServiceInterface;
use App\Repositories\Interfaces\LeaderboardRepositoryInterface;
use App\Repositories\LeaderboardRepository;
use App\Services\Interfaces\LeaderboardServiceInterface;
use App\Services\LeaderboardService;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\AuthRepositoryInterface::class,
            \App\Repositories\AuthRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\LessonRepositoryInterface::class,
            \App\Repositories\LessonRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\QuestionRepositoryInterface::class,
            \App\Repositories\QuestionRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\UserProgressRepositoryInterface::class,
            \App\Repositories\UserProgressRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\OptionRepositoryInterface::class,
            \App\Repositories\OptionRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\FriendRepositoryInterface::class,
            \App\Repositories\FriendRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\FriendRequestRepositoryInterface::class,
            \App\Repositories\FriendRequestRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\MissionRepositoryInterface::class,
            \App\Repositories\MissionRepository::class
         );
      
        $this->app->bind(
            \App\Repositories\Interfaces\UserRepositoryInterface::class,
            \App\Repositories\UserRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\LeaderboardRepositoryInterface::class,
            \App\Repositories\LeaderboardRepository::class
        );

        // Đăng ký service bindings
        $this->app->bind(
            \App\Services\AuthServiceInterface::class,
            \App\Services\AuthService::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\CheckInRepositoryInterface::class,
            \App\Repositories\CheckInRepository::class
        );

        $this->app->bind(
            \App\Services\Interfaces\CheckInServiceInterface::class,
            \App\Services\CheckInService::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\MascotPicRepositoryInterface::class,
            \App\Repositories\MascotPicRepository::class
        );

        $this->app->bind(
            \App\Services\Interfaces\MascotPicServiceInterface::class,
            \App\Services\MascotPicService::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\StoreItemRepositoryInterface::class,
            \App\Repositories\StoreItemRepository::class
        );

        $this->app->bind(
            \App\Services\Interfaces\StoreItemServiceInterface::class,
            \App\Services\StoreItemService::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\UserPurchaseRepositoryInterface::class,
            \App\Repositories\UserPurchaseRepository::class
        );

        $this->app->bind(
            \App\Services\Interfaces\UserPurchaseServiceInterface::class,
            \App\Services\UserPurchaseService::class
        );

        $this->app->bind(
            \App\Services\Interfaces\LessonServiceInterface::class,
            \App\Services\LessonService::class
        );

        $this->app->bind(
            \App\Services\Interfaces\QuestionServiceInterface::class,
            \App\Services\QuestionService::class
        );

        $this->app->bind(
            \App\Services\Interfaces\OptionServiceInterface::class,
            \App\Services\OptionService::class
        );

        $this->app->bind(
            \App\Services\Interfaces\UserProgressServiceInterface::class,
            \App\Services\UserProgressService::class
        );

        $this->app->bind(
            \App\Services\Interfaces\MissionServiceInterface::class,
            \App\Services\MissionService::class
        );

        $this->app->bind(
            \App\Services\Interfaces\LeaderboardServiceInterface::class,
            \App\Services\LeaderboardService::class
        );

        $this->app->bind(MissionRepositoryInterface::class, MissionRepository::class);
        $this->app->bind(MissionServiceInterface::class, MissionService::class);
        
        // User Daily Mission bindings
        $this->app->bind(UserDailyMissionRepositoryInterface::class, UserDailyMissionRepository::class);
        $this->app->bind(UserDailyMissionServiceInterface::class, UserDailyMissionService::class);

        // Register FriendService
        $this->app->singleton(FriendService::class);
        
        // Comment
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
        $this->app->bind(CommentServiceInterface::class, CommentService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
