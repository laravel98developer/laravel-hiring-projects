<?php

namespace App\Enums\DeliveryReport;

use App\Enums\Manager;
use App\Enums\PrepareValuesTrait;

class Status extends Manager
{
    use PrepareValuesTrait;

    public const CREATED = 'CREATED';

    public const PENDING = 'PENDING';

    public const COMPLETED = 'COMPLETED';

    public const VALUES = [
        self::CREATED,
        self::PENDING,
        self::COMPLETED,
    ];

    public static string $type = 'delay_report_states';
}
