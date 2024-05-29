<?php

namespace AliSalehi\Task;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use AliSalehi\Task\Console\Commands\TaskCommand;
use AliSalehi\Task\Http\Middleware\TaskMiddleware;
use AliSalehi\Task\Repositories\Eloquent\TaskRepository;
use AliSalehi\Task\Repositories\TaskRepositoryInterface;

class TaskServiceProvider extends ServiceProvider
{
    private static array $commandNames = [
        TaskCommand::class
    ];
    
    public function register(): void
    {
        $this->mergeConfigFile();
        $this->repositoryBinding();
        $this->app['router']->aliasMiddleware('task-middleware', config('task.middleware', TaskMiddleware::class));
    }
    
    public function boot(): void
    {
        $this->scheduleTask();
        $this->initCommands();
        $this->configurePublishing();
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadTranslationsFrom(__DIR__ .'/../lang', 'TASK');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'NDP');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
    
    private function repositoryBinding(): void
    {
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
    }
    
    private function scheduleTask(): void
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('schedule:tasks')->dailyAt('8:00');
        });
    }
    
    private function initCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands(self::$commandNames);
        }
    }
    
    private function configurePublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [__DIR__ . '/../config' => config_path('/')], ['task', 'task-config']
            );
            $this->publishes(
                [__DIR__ . '/../database/migrations' => database_path('/migrations')], ['task', 'task-migration']
            );
            $this->publishes(
                [__DIR__ . '/../lang/en' => lang_path('/en')], ['task', 'task-lang']
            );
        }
    }
    
    private function mergeConfigFile(): void
    {
        if ($this->app['config']->has('task')) {
            $this->mergeConfigFrom(config_path('task.php'), 'task');
        }
    }
}
