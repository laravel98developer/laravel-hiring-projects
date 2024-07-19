<?php

namespace App\Lib\SMS\Clients\Kavenegar;

use App\Lib\SMS\Clients\Kavenegar\Facades\Kavenegar;
use App\Lib\SMS\Contracts\SMSClientInterface;
use App\Lib\SMS\Messages\Payload;
use Illuminate\Support\Facades\Log;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;

class KavehNegarClient implements SMSClientInterface
{
    const ERRORS = [6, 11, 13, 14, 100];

    public function sendTextMessage(Payload $payload)
    {
        try {
            $sender = '1000888'; // some test number
            $message = $payload->getMessage();
            $receptor = $payload->getTo();
            $result = Kavenegar::Send($sender, $receptor, $message);
            if ($result) {
                foreach ($result as $value) {
                    if (in_array($value->status, self::ERRORS)) {
                        $message = $value->message ?? null;
                        Log::error("Kavenegar error message: $message");
                    }
                }
            }
        } catch (ApiException $e) {
            Log::error("Kavenegar Api error message: {$e->errorMessage()}");
        } catch (HttpException $e) {
            Log::error("Kavenegar Http error message: {$e->errorMessage()}");
        }

        return true;
    }
}
