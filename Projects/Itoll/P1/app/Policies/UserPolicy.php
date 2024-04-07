<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $current_user, User $target_user)
    {
        return $target_user->role === Role::COLLECTION->value && ($current_user->role === Role::ADMIN->value || ($current_user->role === Role::COLLECTION->value && $current_user->id === $target_user->id));
    }
}
