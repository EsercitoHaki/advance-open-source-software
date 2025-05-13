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

        // Đăng ký service bindings
        $this->app->bind(
            \App\Services\AuthServiceInterface::class,
            \App\Services\AuthService::class
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

        // Register FriendService
        $this->app->singleton(FriendService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
