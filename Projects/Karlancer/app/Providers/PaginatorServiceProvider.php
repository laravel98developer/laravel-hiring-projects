<?php

namespace App\Providers;

use App\Http\Helpers\CustomLengthAwarePaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\ServiceProvider;

class PaginatorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(LengthAwarePaginator::class, CustomLengthAwarePaginator::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
