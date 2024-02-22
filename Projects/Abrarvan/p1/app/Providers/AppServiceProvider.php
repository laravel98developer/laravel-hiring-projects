<?php

namespace App\Providers;

use App\Actions\Wallet\ChargeAction;
use App\Repositories\GiftCodeRepository;
use App\Repositories\WalletRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('WalletRepository', WalletRepository::class);
        $this->app->bind('GiftCodeRepository', GiftCodeRepository::class);
        $this->app->bind('ChargeAction', ChargeAction::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
