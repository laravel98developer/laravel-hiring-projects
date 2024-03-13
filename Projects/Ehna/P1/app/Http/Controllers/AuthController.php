<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Repositories\Contracts\AccessTokenRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private UserRepositoryInterface $userRepository;
    private AccessTokenRepositoryInterface $accessTokenRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        AccessTokenRepositoryInterface $accessTokenRepository,
    ) {
        $this->userRepository = $userRepository;
        $this->accessTokenRepository = $accessTokenRepository;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->userRepository->findByUsername($request->input('username'));

        if (is_null($user) || !Hash::check($request->input('password'), $user->getAuthPassword())) {
            return response()->json([
                'message' => 'نام کاربری یا گذرواژه اشتباه است.',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'data' => [
                'token' => $this->accessTokenRepository->create($user, $request->input('device_name')),
            ],
            'message' => 'نام کاربری یا گذرواژه اشتباه است.',
        ], Response::HTTP_CREATED);
    }

    public function logout(): JsonResponse
    {
        $this->accessTokenRepository->deleteCurrentAccessToken();

        return response()->json([
            'message' => 'با موفقیت خارج شدید.',
        ]);
    }
}
