<?php

namespace App\services\NotificationService\SmsNotification;

use Illuminate\Support\Facades\Http;

class Sms
{
    public static function Send(array $data)
    {
        $sms_token = env('SMS_TOKEN');

        $receptor = env('ADMIN_PHONE_NUMBER');
        $message = sprintf("exception while filtering orders %s", $data['exception']);

        Http::get("https://api.kavenegar.com/v1/$sms_token/sms/send.json?$receptor&$message");
    }
}
