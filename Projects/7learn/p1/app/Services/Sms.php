<?php

namespace App\Services;

use nusoap_client;

class Sms
{
    public function send($mobiles, $text)
    {
        $client = new nusoap_client('http://my.candoosms.com/services/?wsdl', true);
        $client->soap_defencoding = 'UTF-8';
        $client->decode_utf8 = false;
        $client->call('Send', array('username' => env('SMS_USERNAME'),'password' => env('SMS_PASSWORD'),'srcNumber' => env('SMS_NUMBER'),'body' => $text,'destNo' => $mobiles,'flash' => '0'));
    }
}
