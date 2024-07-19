<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class FakeServiceProvider extends ServiceProvider
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
        Http::fake([
            'https://run.mocky.io/v3/122c2796-5df4-461c-ab75-87c1192b17f7' => Http::response([
                'data' => [
                    'delay_time' => 50,
                ],
            ]),
        ]);
    }
}
