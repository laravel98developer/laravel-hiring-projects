<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Notifications\BookingConfirmationNotification;

class SendBookingConfirmationEmail
{
    public function handle(BookingCreated $event)
    {
        $booking = $event->booking;

        // Send booking confirmation notification
        $booking->notify(new BookingConfirmationNotification($booking));

        // Update booking status to 'confirmed'
        $booking->update(['status' => 'confirmed']);
    }
}
