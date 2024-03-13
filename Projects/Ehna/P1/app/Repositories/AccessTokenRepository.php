<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\AccessTokenRepositoryInterface;

class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    public function create(User $user, string $name): string
    {
        return $user->createToken($name)->plainTextToken;
    }

    public function deleteCurrentAccessToken(string $guard = null)
    {
        return auth($guard)->user()->currentAccessToken()->delete();
    }
}
