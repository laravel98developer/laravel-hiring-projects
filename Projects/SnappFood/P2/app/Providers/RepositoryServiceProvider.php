<?php

namespace App\Providers;

use App\Contracts\Repository as Contracts;
use App\Repositories\Db as Repositories;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(Contracts\AgentRepository::class, Repositories\AgentRepository::class);
        $this->app->bind(Contracts\DelayReportRepository::class, Repositories\DelayReportRepository::class);
        $this->app->bind(Contracts\DelayReportStatusRepository::class, Repositories\DelayReportStatusRepository::class);
        $this->app->bind(Contracts\OrderRepository::class, Repositories\OrderRepository::class);
        $this->app->bind(Contracts\TripRepository::class, Repositories\TripRepository::class);
        $this->app->bind(Contracts\VendorRepository::class, Repositories\VendorRepository::class);
        $this->app->bind(Contracts\TripStatusRepository::class, Repositories\TripStatusRepository::class);
    }
}
