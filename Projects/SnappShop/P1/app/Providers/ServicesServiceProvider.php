<?php

namespace App\Providers;

use App\Interfaces\Services\DoTransactionServiceInterface;
use App\Services\DoTransactionService;
use Illuminate\Support\ServiceProvider;

class ServicesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        
        $this->app->bind(DoTransactionServiceInterface::class, DoTransactionService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
