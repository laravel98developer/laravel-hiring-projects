<?php

namespace App\Actions\Redis;

use Illuminate\Support\Facades\Redis;

class SubscribeAction
{
    public function handle($channel, array $data): void
    {
        Redis::publish($channel, json_encode($data));
    }
}
