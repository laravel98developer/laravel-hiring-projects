<?php

namespace App\Exceptions;

use App\Utils\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Spatie\FlareClient\Http\Exceptions\NotFound;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        if (config("app.debug"))
            return;

        $this->renderable(function (NotFoundHttpException $e) {
            return Response::error("Not found", 404);
        });

        $this->renderable(function (MethodNotAllowedHttpException $e) {
            return Response::error("Method not allowed", 405);
        });

        $this->renderable(function (NotFound $e) {
            return Response::error("Record not found", 404);
        });

        $this->renderable(function (AuthorizationException $e) {
            return Response::error("Forbidden", 403);
        });

        $this->renderable(function (AuthenticationException $e) {
            return Response::error("Unauthorized", 401);
        });

        $this->renderable(function (QueryException $e) {
            return Response::error("Not found", 404);
        });

        $this->renderable(function (\TypeError $e) {
            return Response::error("Not found", 404);
        });

    }
}
