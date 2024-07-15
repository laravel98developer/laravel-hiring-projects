<?php

namespace App\Http\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseJson
{

    public static function success($data = null, $message = null, $code = 200): JsonResponse
    {
        return response()->json(["data" => $data, "message" => $message], $code);
    }

    public static function error($message = null, $code = 422, $data = []): JsonResponse
    {
        return response()->json(["data" => $data, "message" => $message], $code);
    }

}
