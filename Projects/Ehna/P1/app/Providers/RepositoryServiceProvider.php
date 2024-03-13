<?php

namespace App\Providers;

use App\Repositories\AccessTokenRepository;
use App\Repositories\Contracts\AccessTokenRepositoryInterface;
use App\Repositories\Contracts\PostRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(PostRepositoryInterface::class, PostRepository::class);
        $this->app->singleton(AccessTokenRepositoryInterface::class, AccessTokenRepository::class);
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
    }
}
