<?php

namespace App\Enums;

use Illuminate\Support\Str;

trait PrepareValuesTrait
{
    public static function prepareValues(): string
    {
        return Str::of(collect(self::VALUES)->implode("','"))
            ->start("'")
            ->finish("'");
    }
}
