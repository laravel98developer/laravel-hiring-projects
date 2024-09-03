<?php

namespace App\Schedules;

use App\Models\Booking;
use App\Notifications\ActivityReminderNotification;

class SendBookingReminders
{
    public function __invoke()
    {
        $bookings = Booking::with('activity')
            ->where('status', 'confirmed')
            ->whereHas('activity', function ($query) {
                $query->where('start_date', '<=', now()->addDay());
            })->get();

        foreach ($bookings as $booking) {
            $booking->notify(new ActivityReminderNotification($booking));
        }
    }
}
