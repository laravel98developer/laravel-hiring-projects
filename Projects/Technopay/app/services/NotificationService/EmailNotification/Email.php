<?php

namespace App\services\NotificationService\EmailNotification;

use App\services\NotificationService\NotificationContract;
use Illuminate\Support\Facades\Mail;

class Email implements NotificationContract
{
    public static function send(array $data)
    {
        $content = [
            'subject' => 'order filtering exception ',
            'body'    => sprintf('order filter exception %s', $data['exception'])
        ];

        //Mail::to(env('ADMIN_EMAIL'))->send(new \stdClass($content));
    }
}
