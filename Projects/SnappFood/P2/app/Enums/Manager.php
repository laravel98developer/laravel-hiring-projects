<?php

namespace App\Enums;

use Illuminate\Database\Schema\Grammars\Grammar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

abstract class Manager
{
    public static string $type;

    public static function up()
    {
        $type = static::$type;

        $macroName = 'type'.Str::ucfirst(Str::camel($type));

        Grammar::macro($macroName, fn () => $type);

        DB::unprepared('DROP TYPE IF EXISTS '.$type);
        DB::unprepared('CREATE TYPE '.$type.' AS ENUM ('.static::prepareValues().')');
    }

    public static function down()
    {
        DB::unprepared('DROP TYPE IF EXISTS '.static::$type);
    }

    public static function grammar()
    {
        $type = static::$type;
        $macroName = 'type'.Str::ucfirst(Str::camel($type));
        Grammar::macro($macroName, fn () => $type);
    }

    public static function addValue(string $value, string $after)
    {
        DB::statement('ALTER TYPE '.static::$type." ADD VALUE IF NOT EXISTS '{$value}' AFTER '{$after}'");
    }

    abstract protected static function prepareValues(): string;
}
