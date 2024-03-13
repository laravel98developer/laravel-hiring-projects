<?php

namespace App\Console\Commands;

use App\Jobs\Transaction\AddTransactionJob;
use App\Jobs\Wallet\ChargeWalletJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class RedisSubscribeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe to a Redis channel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Redis::subscribe([env('GIFT_CODE_CHANNEL')], function (string $message) {
            $data = json_decode($message, true);
            ChargeWalletJob::dispatch($data);
            AddTransactionJob::dispatch($data);
        });
    }
}
