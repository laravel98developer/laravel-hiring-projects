<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class RegisterController extends Controller
{

    /**
     * Register api
     *
     * @param RegisterRequest $registerRequest
     * @param UserService $userService
     * @return JsonResponse
     */
    public function index(RegisterRequest $registerRequest, UserService $userService)
    {
        $user = $userService->createUser($registerRequest->validated());
        $user->token = $user->createToken('SnappFood')->accessToken;
        return response()->success( __('messages.user_register_successfully'), Response::HTTP_CREATED,new UserResource($user));
    }

}
