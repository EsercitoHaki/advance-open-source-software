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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
