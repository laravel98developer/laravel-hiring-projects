<?php

namespace App\Service\MockDelay;

class GetMockDelayTimeRequest extends MockDelayService
{
    protected string $method = 'GET';

    protected string $path = 'v3/122c2796-5df4-461c-ab75-87c1192b17f7';

    protected function rules(): array
    {
        return [
            'data.delay_time' => [
                'required',
                'numeric',
            ],
        ];
    }
}
