<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof NotFoundHttpException || $e instanceof ModelNotFoundException) {
            return response()->error(
                __('messages.not_found'),
                Response::HTTP_NOT_FOUND
            );
        }

        if ($e instanceof ValidationException) {
            return response()->error(
                __('messages.bad_request'),
                Response::HTTP_UNPROCESSABLE_ENTITY,
                $e->errors()
            );
        }

        return response()->error(
            __('messages.bad_request'),
            Response::HTTP_BAD_REQUEST,
            $e->getMessage()
        );

    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->error(
            __('messages.unauthenticated'),
            Response::HTTP_UNAUTHORIZED
        );
    }
}
