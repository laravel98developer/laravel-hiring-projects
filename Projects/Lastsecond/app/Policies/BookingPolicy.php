<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    public function viewAny(User $user)
    {
        // Allow viewing bookings for all authenticated users
        return true;
    }

    public function view(User $user, Booking $booking)
    {
        // Allow a user to view their own bookings, or allow admins to view any booking
        return $user->email === $booking->user_email || $user->is_admin;
    }

    public function create(User $user)
    {
        // Allow all authenticated users to create bookings
        return true;
    }

    public function update(User $user, Booking $booking)
    {
        // Allow a user to update their own bookings, or allow admins to update any booking
        return $user->is_admin;
    }

    public function delete(User $user, Booking $booking)
    {
        // Allow a user to delete their own bookings, or allow admins to delete any booking
        return $user->is_admin;
    }
}
