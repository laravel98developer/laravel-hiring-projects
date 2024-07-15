<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseJson;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::query()->create($request->validated());

        $user->sendEmailVerificationNotification();

        $token = $user->createToken("token")->plainTextToken;

        return ResponseJson::success(["token" => $token], "user registered successfully", Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt(["email" => $request->email, "password" => $request->password])) {
            $user = Auth::user();

            $token = $user->createToken("token")->plainTextToken;

            return ResponseJson::success(["token" => $token], "user logged in successfully", Response::HTTP_OK);
        }

        return ResponseJson::error("email or password invalid", Response::HTTP_BAD_REQUEST);
    }

    public function logout(): JsonResponse
    {
        $user = Auth::user();

        $user->currentAccessToken()->delete();

        return ResponseJson::success(message: "logged out successfully", code: Response::HTTP_ACCEPTED);
    }
}
