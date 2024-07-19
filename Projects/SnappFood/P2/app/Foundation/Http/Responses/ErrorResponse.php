<?php

namespace App\Foundation\Http\Responses;

use App\Exceptions\ServiceException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ErrorResponse
{
    private array $trace;

    private string $line;

    private string $file;

    private array $result;

    private string $code;

    private string $message;

    public static function make(): static
    {
        return new static();
    }

    public function handler(Throwable $exception): JsonResponse
    {
        $this->trace = $exception->getTrace();
        $this->file = $exception->getFile();
        $this->line = $exception->getLine();
        $this->message = $exception->getMessage();

        $class = get_class($exception);

        return match ($class) {
            ValidationException::class => $this->fail(
                Response::HTTP_BAD_REQUEST,
                Response::HTTP_BAD_REQUEST,
                'the given data was invalid',
                $exception->errors()
            ),
            NotFoundHttpException::class => $this->fail(
                Response::HTTP_NOT_FOUND,
                Response::HTTP_NOT_FOUND,
                'page not found'
            ),
            MethodNotAllowedHttpException::class => $this->fail(
                Response::HTTP_METHOD_NOT_ALLOWED,
                Response::HTTP_METHOD_NOT_ALLOWED,
                'method not allowed'
            ),
            ModelNotFoundException::class => $this->fail(
                Response::HTTP_NOT_FOUND,
                Response::HTTP_NOT_FOUND,
                'entity not found'
            ),
            QueryException::class => $this->fail(
                $this->isDuplicateQueryError($exception) ? 400 : 500,
                $this->isDuplicateQueryError($exception) ? 400 : 500,
                'query error'
            ),
            \TypeError::class => $this->fail(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                Response::HTTP_INTERNAL_SERVER_ERROR,
                'type error'
            ),
            ServiceException::class => $this->serviceException(
                $exception->getErrors(),
                $exception->getCode()
            ),
            default => $this->fail(
                empty($exception->getCode()) ? Response::HTTP_INTERNAL_SERVER_ERROR : $exception->getCode(),
                empty($exception->getCode()) ? Response::HTTP_INTERNAL_SERVER_ERROR : $exception->getCode(),
                $exception->getMessage()
            ),
        };
    }

    public function fail(int $status, int $code = 400, ?string $message = null, array $error = []): JsonResponse
    {
        $this->code = $code;

        $locale = trans('messages.'.$message, [], 'fa');
        $this->result['errors'] = [
            'status' => $status,
            'detail' => $message,
            'detail_locale' => str_starts_with($locale, 'messages.') ? $message : $locale,
        ];

        if ($error) {
            $this->result['errors']['fields'] = $error;
        }

        if (config('app.debug', false)) {
            $this->result['errors']['debug'] = [
                'message' => $this->message,
                'line' => $this->line,
                'file' => $this->file,
                'trace' => collect($this->trace)->map(function ($trace) {
                    return Arr::except($trace, ['args']);
                })->all(),
            ];
        }

        return $this->returner();
    }

    private function returner(): JsonResponse
    {
        return response()->json($this->result, $this->code);
    }

    private function isDuplicateQueryError(Throwable $exception): int
    {
        return Str::contains($exception->getMessage(), 'Duplicate');
    }

    private function serviceException(?array $errors, $code): JsonResponse
    {
        if (! $errors) {
            return $this->fail($code, $code, 'the connection is disconnected');
        }

        $this->code = $code;

        $this->result = $errors;

        return $this->returner();
    }
}
