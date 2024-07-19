<?php

namespace App\Enums;

use Illuminate\Support\Collection;

class Transform
{
    public static function formatter($value): array
    {
        return [
            'id' => $value,
            'title' => __('enums.'.$value),
        ];
    }

    public static function mapper(array $enums): Collection
    {
        return collect($enums)->map(fn ($value) => self::formatter($value));
    }
}
