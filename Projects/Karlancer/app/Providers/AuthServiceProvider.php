<?php

namespace App\Providers;

use App\Policies\v1\TodoPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
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
        Gate::define("todo-view", [TodoPolicy::class, "view"]);
        Gate::define("todo-update", [TodoPolicy::class, "update"]);
        Gate::define("todo-delete", [TodoPolicy::class, "delete"]);
    }
}
