<?php

namespace App\Providers;

use App\Lib\Inquiry\Inquiry;
use App\Lib\SMS\Clients\Kavenegar\KavehNegarClient;
use App\Lib\SMS\Contracts\SMSClientInterface;
use Ghasedak\GhasedakApi;
use Illuminate\Support\ServiceProvider;
use Kavenegar\KavenegarApi;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Inquiry
        $this->app->singleton('inquiry', function () {
            $config = config('inquiry') ?? [];

            return new Inquiry($config);
        });

        // SMS
        $this->app->singleton('kavenegar', function ($app) {
            return new KavenegarApi($app['config']->get('sms.clients.kavenegar.api_key'));
        });
        $this->app->bind('ghasedak', function ($app) {
            return new GhasedakApi($app['config']->get('sms.clients.ghasedak.api_key'));
        });
        $this->app->singleton(SMSClientInterface::class, KavehNegarClient::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
