<?php

namespace App\Enums\Tripe;

use App\Enums\Manager;
use App\Enums\PrepareValuesTrait;

class Status extends Manager
{
    use PrepareValuesTrait;

    public const ASSIGNED = 'ASSIGNED';

    public const VENDOR_AT = 'VENDOR_AT';

    public const PICKED = 'PICKED';

    public const DELIVERED = 'DELIVERED';

    public const VALUES = [
        self::ASSIGNED,
        self::VENDOR_AT,
        self::PICKED,
        self::DELIVERED,
    ];

    public static string $type = 'trip_states';
}
