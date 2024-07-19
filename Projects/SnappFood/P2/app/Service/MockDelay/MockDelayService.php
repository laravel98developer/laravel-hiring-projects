<?php

namespace App\Service\MockDelay;

use App\Enums\Supplier;
use App\Foundation\Transporter\Request;
use Illuminate\Http\Client\PendingRequest;

class MockDelayService extends Request
{
    protected function url(): string
    {
        return config('external_service.'.Supplier::MOCK_DELAY.'.base_url');
    }

    protected function withRequest(PendingRequest $request): void
    {
        $request->timeout(config('external_service.'.Supplier::MOCK_DELAY.'.timeout'));
    }
}
