<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ActivityReminderNotification extends Notification implements ShouldQueue
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
            ->subject('Activity Reminder')
            ->greeting('Hello ' . $this->booking->user_name)
            ->line('This is a reminder for your upcoming activity: ' . $this->booking->activity->name)
            ->line('Activity Details:')
            ->line('Location: ' . $this->booking->activity->location)
            ->line('Date: ' . $this->booking->activity->start_date->format('M d, Y H:i'))
            ->line('Slots Booked: ' . $this->booking->slots_booked)
            ->line('We look forward to seeing you there!');
    }
}
