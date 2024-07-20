<?php

namespace App\Helpers;

class DateHelper
{
    public static function addTimeToNow($number, $type)
    {
        $dateTime = new \DateTime(now());
                $dateTime->modify('+' . $number . " $type");
        return $dateTime->format('Y-m-d H:i:s');
    }
}
