<?php

namespace App\Lib\SMS\Clients\Kavenegar\Facades;

use Illuminate\Support\Facades\Facade;

class Kavenegar extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'kavenegar';
    }
}
