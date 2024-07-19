<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\LoginRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::whereMobile($request->validated()['mobile'])->firstOrFail();
        $token = $user->createToken('testing')->plainTextToken;

        return $this->jsonResponse(
            data: [
                'token' => $token,
            ],
            message: __('message.login.successful')
        );
    }
}
