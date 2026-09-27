<?php

namespace App\Providers;

use App\Repositories\Contracts\LicenseRepositoryInterface;
use App\Repositories\Eloquent\LicenseRepository;
use App\Services\Contracts\OrderServiceInterface;
use App\Services\Services\OrderService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LicenseRepositoryInterface::class, LicenseRepository::class);
        $this->app->bind(OrderServiceInterface::class, OrderService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
