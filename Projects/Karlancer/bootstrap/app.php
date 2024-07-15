<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Helpers\ResponseJson;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        apiPrefix: "/api/v1"
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('api', [
            \App\Http\Middleware\AlwaysResponseJson::class,
            \Rakutentech\LaravelRequestDocs\LaravelRequestDocsMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        if (config("app.debug")) {
            return;
        }

        $exceptions->renderable(function (NotFoundHttpException $e) {
            return ResponseJson::error("not found", Response::HTTP_NOT_FOUND);
        });

        $exceptions->renderable(function (TypeError $e) {
            return ResponseJson::error("not found", Response::HTTP_NOT_FOUND);
        });

        $exceptions->renderable(function (ModelNotFoundException $e) {
            return ResponseJson::error("not found", Response::HTTP_NOT_FOUND);
        });


    })->create();
