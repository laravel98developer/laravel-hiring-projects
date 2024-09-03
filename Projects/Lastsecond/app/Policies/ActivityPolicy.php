<?php

namespace App\Policies;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;

class ActivityPolicy
{
    public function viewAny(User $user)
    {
        Gate::authorize('viewAny', Activity::class);

        // Allow viewing activities for all authenticated users
        return true;
    }

    public function view(User $user, Activity $activity)
    {
        Gate::authorize('view', $activity);

        // Allow viewing a specific activity for all authenticated users
        return true;
    }

    public function create(User $user)
    {
        Gate::authorize('create', Activity::class);

        // Only allow admin users to create activities
        return $user->is_admin;
    }

    public function update(User $user, Activity $activity)
    {
        Gate::authorize('update', $activity);

        // Only allow admin users to update activities
        return $user->is_admin;
    }

    public function delete(User $user, Activity $activity)
    {
        Gate::authorize('delete', $activity);

        // Only allow admin users to delete activities
        return $user->is_admin;
    }
}
