<?php

namespace App\Notifications\Channels;

use App\Exceptions\FailedNotification;
use App\Lib\SMS\Contracts\SMSClientInterface;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Notifications\Notification;

class SMSChannel
{
    public function __construct(
        protected SMSClientInterface $client,
        private ?Dispatcher $dispatcher = null
    ) {
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSMS($notifiable);

        try {
            $response = $this->client->sendTextMessage($message->getPayload());

            if ($this->dispatcher !== null) {
                $this->dispatcher->dispatch(self::class, [$notifiable, $notification, $response]);
            }
        } catch (FailedNotification $e) {
            if ($this->dispatcher !== null) {
                $this->dispatcher->dispatch(
                    new NotificationFailed(
                        $notifiable,
                        $notification,
                        self::class,
                        $e->getMessage()
                    )
                );
            }
        }
    }
}
