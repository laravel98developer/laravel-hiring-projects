<?php

namespace App\Lib\SMS\Clients\Ghasedak\Facades;

use Illuminate\Support\Facades\Facade;

class Ghasedak extends Facade
{
    const VERIFY_MESSAGE_TEXT = 1;

    const VERIFY_MESSAGE_VOICE = 2;

    const MESSAGE_ID_TYPE = 1;

    const CHECK_ID_TYPE = 2;

    protected static function getFacadeAccessor()
    {
        return 'ghasedak';
    }
}
