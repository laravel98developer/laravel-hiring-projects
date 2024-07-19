<?php

declare(strict_types=1);

namespace App\Lib\SMS\Messages;

use App\Lib\SMS\Contracts\SMSMessageInterface;

class MessageRepository implements SMSMessageInterface
{
    protected string $mobile;

    protected string $message;

    public function to(string $to): self
    {
        $this->mobile = $to;

        return $this;
    }

    public function message(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getPayload(): Payload
    {
        return (new Payload())->setMessage($this->message)->setTo($this->mobile);
    }
}
