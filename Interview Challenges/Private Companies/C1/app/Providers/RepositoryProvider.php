<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $path = app()->path() . '/Repositories';
        $directories = array_diff(scandir($path, SCANDIR_SORT_NONE), ['.', '..', 'BaseRepository.php', 'BaseRepositoryInterface.php']);

        foreach ($directories as $directory) {
            $interface = "App\Repositories\\$directory\\{$directory}RepositoryInterface";
            $implementation = "App\Repositories\\$directory\\{$directory}Repository";
            $this->app->singleton($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
