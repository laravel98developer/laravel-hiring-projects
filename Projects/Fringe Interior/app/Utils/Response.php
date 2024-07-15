<?php

namespace App\Utils;

class Response
{
    public static function success($data,string $message = null ,int $status = 200){
        return response()->json(["status" => "success", "data" => $data, "message" => $message], $status);
    }

    public static function error(string $message, int $status = 422, $data = null){
        return response()->json(["status" => "error", "data" => $data, "message" => $message], $status);
    }
}
