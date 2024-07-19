<?php

namespace App\Models\Enums;

enum TransactionStatusEnum: int
{
    case Done = 100;
    case Failed = -100;

    public function displayTitle(): string
    {
        return match ($this) {
            static::Done => __('strings.transaction.status.done'),
            static::Failed => __('strings.transaction.status.failed'),
        };
    }
}
