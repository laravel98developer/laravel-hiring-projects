<?php

namespace App\Providers;

use App\Contracts\Services\OrderServiceInterface;
use App\Contracts\Services\ProductServiceInterface;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Support\ServiceProvider;

class FacilityServiceProvider extends ServiceProvider
{
    public array $singletons = [
        ProductServiceInterface::class => ProductService::class,
        OrderServiceInterface::class => OrderService::class
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
