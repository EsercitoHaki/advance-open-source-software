<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\AuthRepositoryInterface;
use App\Repositories\AuthRepository;
use App\Services\AuthServiceInterface;
use App\Services\AuthService;
use App\Repositories\LessonRepositoryInterface;
use App\Repositories\LessonRepository;
use App\Services\LessonServiceInterface;
use App\Services\LessonService;
use App\Repositories\QuestionRepositoryInterface;
use App\Repositories\QuestionRepository;
use App\Services\QuestionServiceInterface;
use App\Services\QuestionService;


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
            \App\Repositories\LessonRepositoryInterface::class,
            \App\Repositories\LessonRepository::class
        );

        $this->app->bind(
            \App\Repositories\QuestionRepositoryInterface::class,
            \App\Repositories\QuestionRepository::class
        );

        // Đăng ký service bindings
        $this->app->bind(
            \App\Services\AuthServiceInterface::class,
            \App\Services\AuthService::class
        );

        $this->app->bind(
            \App\Services\LessonServiceInterface::class,
            \App\Services\LessonService::class
        );

        $this->app->bind(
            \App\Services\QuestionServiceInterface::class,
            \App\Services\QuestionService::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
