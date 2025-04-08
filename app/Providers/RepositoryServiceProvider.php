<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\AuthRepositoryInterface;
use App\Repositories\AuthRepository;
use App\Services\AuthServiceInterface;
use App\Services\AuthService;


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
        
        // Đăng ký service bindings
        $this->app->bind(
            \App\Services\AuthServiceInterface::class,
            \App\Services\AuthService::class
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
