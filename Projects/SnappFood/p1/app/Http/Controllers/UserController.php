<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserSigninRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Sign in to the account using email,username or mobile and password.
     *
     * @param UserSigninRequest $request
     * @return Application|ResponseFactory|\Illuminate\Foundation\Application|Response|void
     */
    public function signin(UserSigninRequest $request)
    {
        auth()->attempt([
            'email' => $request->string('email'),
            'password' => $request->string('password'),
        ]);
        if (auth()->check()) {
            $token = auth()->user()->createToken('user-signin-token');
            return response([
                'plainTextToken' => $token->plainTextToken,
            ]);
        }
    }

    /**
     * Revoke current access token.
     *
     * @return Application|ResponseFactory|\Illuminate\Foundation\Application|Response
     */
    public function signout()
    {
        request()->user()->tokens()->delete();

        return response();
    }
}
