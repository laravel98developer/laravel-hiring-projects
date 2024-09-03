<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingConfirmationNotification extends Notification implements ShouldQueue
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
            ->subject('Booking Confirmation')
            ->greeting('Hello ' . $this->booking->user_name)
            ->line('Your booking for ' . $this->booking->activity->name . ' has been confirmed.')
            ->line('Activity Details:')
            ->line('Location: ' . $this->booking->activity->location)
            ->line('Date: ' . $this->booking->activity->start_date->format('M d, Y H:i'))
            ->line('Slots Booked: ' . $this->booking->slots_booked)
            ->line('Thank you for booking with us!');
    }
}
