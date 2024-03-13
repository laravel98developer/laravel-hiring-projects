<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Repositories\Contracts\AccessTokenRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class RegisterController extends Controller
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

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->userRepository->create([
            'username' => strtolower($request->input('username')),
            'password' => bcrypt($request->input('password')),
        ]);

        return response()->json([
            'data' => [
                'token' => $this->accessTokenRepository->create($user, $request->input('device_name')),
            ],
            'message' => 'ثبت نام با موفقیت انجام شد.',
        ], Response::HTTP_CREATED);
    }
}
