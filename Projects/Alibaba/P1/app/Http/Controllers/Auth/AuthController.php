<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\Auth\AuthService;

class AuthController extends Controller
{
    /**
     * The AuthService instance.
     *
     * @var AuthService
     */
    protected $authService;

    /**
     * Create a new controller instance.
     *
     * @param AuthService $authService The AuthService instance.
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Refresh the access token using the refresh token.
     *
     * @param Request $request The HTTP request.
     * @return JsonResponse The JSON response.
     */
    public function refreshToken(Request $request): JsonResponse
    {

        $refreshToken = $request->input('refresh_token');

        $accessToken = $this->authService->refreshToken($refreshToken);

        if ($accessToken) {
            return response()->json(['access_token' => $accessToken], 200);
        }

        return response()->json(['message' => 'Failed to refresh token'], 401);
    }
}
