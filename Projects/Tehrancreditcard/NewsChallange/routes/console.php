<?php

use App\Http\Controllers\NewsController;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule ;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Schedule::call(function () {
    $newsController = app(NewsController::class);
    $newsController->storeNewsFromNewsAPI();
    $newsController->storeNewsFromGuardian();

})->hourly(); 