<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseJson;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function show(): JsonResponse
    {
        return ResponseJson::success(Auth::user(), 'show authenticated user', Response::HTTP_OK);
    }

}
