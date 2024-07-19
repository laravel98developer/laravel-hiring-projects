<?php

declare(strict_types=1);

namespace App\Lib\SMS\Contracts;

use App\Lib\SMS\Messages\Payload;

interface SMSClientInterface
{
    public function sendTextMessage(Payload $payload);
}
