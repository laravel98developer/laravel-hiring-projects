<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseJson;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EmailVerificationController extends Controller
{
    public function verify(int $id): JsonResponse
    {
        $user = User::query()->findOrFail($id);

        if ($user->hasVerifiedEmail()) {
            return ResponseJson::error("email already verified", Response::HTTP_BAD_REQUEST);
        }

        if (!$user->markEmailAsVerified()) {
            return ResponseJson::error("email verification failed", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return ResponseJson::success(null, "email verified successfully", Response::HTTP_OK);
    }

    public function resend(): JsonResponse
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return ResponseJson::error("email already verified", Response::HTTP_BAD_REQUEST);
        }

        $user->sendEmailVerificationNotification();

        return ResponseJson::success(null, 'email verification link sent to your email address', Response::HTTP_ACCEPTED);
    }
}
