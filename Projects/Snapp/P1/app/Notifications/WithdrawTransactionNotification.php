<?php

namespace App\Notifications;

use App\Lib\SMS\Messages\MessageRepository;
use App\Notifications\Channels\SMSChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class WithdrawTransactionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $accountNumber,
        public string $amount,
        public string $method,
        public string $balance,
        public string $dateTime,
    ) {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [SMSChannel::class];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'account_number' => $this->accountNumber,
            'amount' => $this->amount,
            'method' => $this->method,
            'balance' => $this->balance,
            'date_time' => $this->dateTime,
        ];
    }

    public function toSMS(object $notifiable)
    {
        return (new MessageRepository())->to($notifiable->mobile)->message($this->message($this->toArray($notifiable)));
    }

    public static function message(array $data): string
    {
        return <<<TEXT

        شماره حساب: {$data['account_number']}
        برداشت: {$data['amount']}
        از طریق: {$data['method']}
        مانده حساب: {$data['balance']} ریال
        تاریخ: {$data['date_time']}

        TEXT;
    }
}
