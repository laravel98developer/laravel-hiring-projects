<?php

namespace App\Channels;

use GuzzleHttp\Client;
use Illuminate\Log\Logger;
use Illuminate\Notifications\Notification;

class WebhookChannel
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var Logger
     */
    private $logger;

    public function __construct(Client $client, Logger $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    public function send($notifiable, Notification $notification)
    {
        $body = $notification->toWebhook($notifiable);
        if(!is_null($notifiable->webhook_url)) {
            $this->client->post("https://webhook.site/6728e249-eb55-4b70-a311-7fb051e8629d", $body); // just a simple send, we can add more...
        }
    }
}