<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface AccessTokenRepositoryInterface
{
    public function create(User $user, string $name): string;

    public function deleteCurrentAccessToken(string $guard = null);
}
