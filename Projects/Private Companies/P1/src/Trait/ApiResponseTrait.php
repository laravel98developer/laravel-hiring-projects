<?php

namespace AliSalehi\Task\Trait;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponseTrait
{
    public function successResponse(mixed $data, string $message = '', int $status = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'status'  => $status,
            'message' => $message,
            'result'  => $data
        ], $status);
    }
    
    public function errorResponse(array|string $errors, string $errorMessages = '', int $status = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return response()->json([
            'status'  => $status,
            'message' => $errorMessages,
            'errors'  => $errors
        ], $status);
    }
}
