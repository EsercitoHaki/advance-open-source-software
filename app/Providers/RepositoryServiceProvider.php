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

        $this->app->bind(
            \App\Repositories\CheckInRepositoryInterface::class,
            \App\Repositories\CheckInRepository::class
        );

        $this->app->bind(
            \App\Services\CheckInServiceInterface::class,
            \App\Services\CheckInService::class
        );

        $this->app->bind(
            \App\Repositories\MascotPicRepositoryInterface::class,
            \App\Repositories\MascotPicRepository::class
        );

        $this->app->bind(
            \App\Services\MascotPicServiceInterface::class,
            \App\Services\MascotPicService::class
        );

        $this->app->bind(
            \App\Repositories\StoreItemRepositoryInterface::class,
            \App\Repositories\StoreItemRepository::class
        );

        $this->app->bind(
            \App\Services\StoreItemServiceInterface::class,
            \App\Services\StoreItemService::class
        );

        $this->app->bind(
            \App\Repositories\UserPurchaseRepositoryInterface::class,
            \App\Repositories\UserPurchaseRepository::class
        );

        $this->app->bind(
            \App\Services\UserPurchaseServiceInterface::class,
            \App\Services\UserPurchaseService::class
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
