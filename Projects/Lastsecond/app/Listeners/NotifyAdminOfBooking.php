<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Models\User;
use App\Notifications\AdminBookingNotification;
use Illuminate\Support\Facades\Notification;

class NotifyAdminOfBooking
{
    public function handle(BookingCreated $event)
    {
        $booking = $event->booking;

        // Notify admins of the new booking
        $admins = User::where('is_admin', true)->get();
        Notification::send($admins, new AdminBookingNotification($booking));
    }
}
