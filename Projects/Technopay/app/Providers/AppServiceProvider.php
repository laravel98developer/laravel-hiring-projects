<?php

namespace App\Providers;

use App\services\OrderService\Contracts\OrderRepositoryInterface;
use App\services\OrderService\Repositories\OrderRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
    }
}
