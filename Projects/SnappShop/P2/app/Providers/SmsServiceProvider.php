<?php

namespace App\Providers;

use App\Services\SmsService\Kavenegar;
use App\Services\SmsService\SmsServiceInterface;
use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SmsServiceInterface::class, fn () => new Kavenegar(config('services.kavenegar.key')));
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
