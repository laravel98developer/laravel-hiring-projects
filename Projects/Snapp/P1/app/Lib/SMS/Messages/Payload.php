<?php

declare(strict_types=1);

namespace App\Lib\SMS\Messages;

class Payload
{
    private string $to;

    private string $messageText;

    public function getMessage(): string
    {
        return $this->messageText;
    }

    public function setMessage(string $messageText): self
    {
        $this->messageText = $messageText;

        return $this;
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function setTo(string $to): self
    {
        $this->to = $to;

        return $this;
    }
}
