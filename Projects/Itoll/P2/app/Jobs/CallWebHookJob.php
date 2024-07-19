<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CallWebHookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected int $orderId, protected string $lat, protected string $lon)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // TODO:: where the webhook must placed in
        logger('job called', [
            'order_id' => $this->orderId,
            'latitude' => $this->lat,
            'longitude' => $this->lon,
        ]);
    }
}
