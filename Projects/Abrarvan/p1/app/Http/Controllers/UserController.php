<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Services\UserService;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function successTransactions($code): UserResource
    {
        $response = $this->userService->successTransactions($code);

        return new UserResource($response);
    }
}
