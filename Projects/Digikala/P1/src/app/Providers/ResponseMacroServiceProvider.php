<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use \Illuminate\Http\Response as HTTPResponse;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
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
        Response::macro('success', function ($message, $status = HTTPResponse::HTTP_OK, $data = '') {
            return Response::json([
                'message' => $message,
                'data' => $data,
            ], $status);
        });

        Response::macro('error', function ($message, $status = HTTPResponse::HTTP_OK,  $errors = '') {
            return Response::json([
                'message' => $message,
                'errors' => $errors,
            ], $status);
        });
    }
}
