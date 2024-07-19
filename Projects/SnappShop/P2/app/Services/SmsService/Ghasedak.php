<?php

namespace App\Services\SmsService;

class Ghasedak implements SmsServiceInterface
{
    public function sendSms(string $recipient, string $message): bool
    {
        return true;
    }
}
