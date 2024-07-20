<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class RegisterAction extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService=$userService;
    }


    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return $this->userService->register($request->all());
    }
}
