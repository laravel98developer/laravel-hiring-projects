<?php

namespace App\Lib\SMS\Clients\Ghasedak;

use App\Lib\SMS\Clients\Ghasedak\Facades\Ghasedak;
use App\Lib\SMS\Contracts\SMSClientInterface;
use App\Lib\SMS\Messages\Payload;
use Ghasedak\Exceptions\ApiException;
use Ghasedak\Exceptions\HttpException;
use Illuminate\Support\Facades\Log;

class GhasedakClient implements SMSClientInterface
{
    public function sendTextMessage(Payload $payload)
    {
        try {
            $sender = '300004545'; // some test number
            $message = $payload->getMessage();
            $receptor = $payload->getTo();
            Ghasedak::SendSimple($receptor, $message, $sender);
        } catch (ApiException $e) {
            Log::error("Ghasedak Api error message: {$e->errorMessage()}");
        } catch (HttpException $e) {
            Log::error("Ghasedak Http error message: {$e->errorMessage()}");
        }

        return true;
    }
}
