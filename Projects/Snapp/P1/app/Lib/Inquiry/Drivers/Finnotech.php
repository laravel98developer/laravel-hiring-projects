<?php

declare(strict_types=1);

namespace App\Lib\Inquiry\Drivers;

use App\Lib\Inquiry\Contracts\InquiryInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Finnotech implements InquiryInterface
{
    const DONE = 'DONE';

    const FAILED = 'FAILED';

    public function __construct(
        public array $config
    ) {
    }

    public function validateCardNumber(string $cardNumber)
    {
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->config['token']}",
        ])->get("{$this->config['url']}/mpg/v2/clients/{$this->config['client_id']}//cards/{$cardNumber}");

        if ($response->successful() && $response->object()?->status === self::DONE) {
            return $response->object()->result['result'] === '0';
        } elseif ($response->failed() && $response->object()?->status === self::FAILED) {
            Log::warning("Finnotech api connection failed with message: {$response->object()?->error['message']}");
        } else {
            Log::warning('Finnotech api connection failed without error message.');
        }

        $response->throwUnlessStatus(200);
    }
}
