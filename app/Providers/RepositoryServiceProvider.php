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

        // Đăng ký service bindings
        $this->app->bind(
            \App\Services\AuthServiceInterface::class,
            \App\Services\AuthService::class
        );

        $this->app->bind(
            \App\Services\LessonServiceInterface::class,
            \App\Services\LessonService::class
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
