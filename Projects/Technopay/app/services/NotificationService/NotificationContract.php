<?php

namespace App\services\NotificationService;

interface NotificationContract
{
    public static function send(array $data);
}
