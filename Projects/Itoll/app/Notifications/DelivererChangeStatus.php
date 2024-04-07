<?php

namespace App\Notifications;

use App\Channels\WebhookChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DelivererChangeStatus extends Notification
{
    use Queueable;
    private $message;
    private $delivery_request_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $delivery_request_id, string $message)
    {
        $this->message = $message . __('notification.delimeter') .  __('notification.time', ['time' => now()]);
        $this->delivery_request_id = $delivery_request_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WebhookChannel::class];
    }

    /**
     * Get the webhook representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toWebhook($notifiable)
    {
        return [
            'message' => $this->message,
            'delivery_request_id' => $this->delivery_request_id,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
