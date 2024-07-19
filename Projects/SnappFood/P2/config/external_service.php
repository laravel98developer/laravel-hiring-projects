<?php

return [
    \App\Enums\Supplier::MOCK_DELAY => [
        'base_url' => env('MOCK_DELAY_URL', 'https://run.mocky.io'),
        'timeout' => env('MOCK_DELAY_TIMEOUT', 30),
    ],
];
