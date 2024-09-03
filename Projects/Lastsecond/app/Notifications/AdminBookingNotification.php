<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminBookingNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Booking Made')
            ->greeting('Hello Admin,')
            ->line('A new booking has been made by ' . $this->booking->user_name)
            ->line('Activity: ' . $this->booking->activity->name)
            ->line('Location: ' . $this->booking->activity->location)
            ->line('Date: ' . $this->booking->activity->start_date->format('M d, Y H:i'))
            ->line('Slots Booked: ' . $this->booking->slots_booked)
            ->line('Please check the admin panel for more details.');
    }
}
