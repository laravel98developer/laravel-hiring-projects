<?php

namespace App\Services\SmsService;

interface SmsServiceInterface
{
    public function sendSms(string $recipient, string $message): bool;
}
