<?php

namespace App\Notifications;

use App\Models\Card;
use App\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SmsToClient extends Notification
{
    use Queueable;

    protected Card $card;
    protected $amount;
    protected $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(Card $card, $amount, $message)
    {
        
        $this->card = $card;
        $this->amount = $amount;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', SmsChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toSms()
    {
       
        return str_replace(['{Account}', '{Amount}'], [$this->card->account->account_number, $this->amount], $this->message);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
