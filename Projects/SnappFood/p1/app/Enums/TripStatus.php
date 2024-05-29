<?php

namespace App\Enums;

enum TripStatus: int
{
    case ASSIGNED = 1;
    case AT_VENDOR = 2;
    case PICKED = 3;
    case DELIVERED = 4;

    public static function fromValue(int $value): ?string
    {
        foreach (self::cases() as $case) {
            if ($case->value === $value) {
                return $case->name;
            }
        }

        return null;
    }
}
