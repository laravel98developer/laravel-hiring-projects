<?php

namespace App\Channels;

use Illuminate\Support\Facades\Http;
use Illuminate\Notifications\Notification;

class SmsChannel {

    public function send($notifiable, Notification $notification)
    {

        $response = Http::withoutVerifying()
            ->withOptions(['verify' => false])
            ->post('https://api.kavenegar.com/v1/356C5A616169764C4B6F47463865727031662F4F774533676F516138584D4C5167365A6F52475A337A59633D/sms/send.json', [
            'receptor' => $notifiable->phone,
            'message' => $notification->toSms($notifiable),
        ]);

        // dd($response, $response->body());
    }
}