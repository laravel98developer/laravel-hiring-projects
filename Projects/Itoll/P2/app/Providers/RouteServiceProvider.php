<?php

namespace App\Providers;

use App\Http\Middleware\DeliveryChecker;
use App\Http\Middleware\SupplyChecker;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(function () {
                    Route::middleware(DeliveryChecker::class)
                        ->prefix('delivery')
                        ->group(base_path('routes/apis/delivery.php'));

                    Route::middleware(SupplyChecker::class)
                        ->prefix('supply')
                        ->group(base_path('routes/apis/supply.php'));
                });
        });
    }
}
