<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    /**
     * Login api
     *
     * @param LoginRequest $loginRequest
     * @param UserService $userService
     * @return JsonResponse
     */
    public function index(LoginRequest $loginRequest, UserService $userService)
    {

        $user = $userService->login($loginRequest->validated());
        if($user){
            $user->token = $user->createToken('Review')->accessToken;
            return response()->success(__('messages.user_login_successfully'),
                Response::HTTP_OK,
                new UserResource($user));
        }
        return response()->error(__('messages.user_login_failed'), Response::HTTP_BAD_REQUEST);
    }
}
