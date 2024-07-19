<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function jsonResponse(JsonResource|array $data = [], ?string $message = null, int $status = 200)
    {
        return response()->json(['data' => $data, 'message' => $message], $status);
    }
}
