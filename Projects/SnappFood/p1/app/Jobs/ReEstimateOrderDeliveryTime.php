<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ReEstimateOrderDeliveryTime implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Order $order) {}

    /**
     * Execute the job.
     * @throws \Throwable
     */
    public function handle(): void
    {
        try {
            /*
             * todo: The url below is provided by snappfood task to be used but it does not work and returns 404!
            */
            $response = Http::retry(3, 2000)
                ->get(config('services.reestimation_delivery_time.webservice_url'));
            if ($response->successful()) {
                $this->order->update(['delivery_time' => $response->body()]);
            } else {
                $this->order->update(['delivery_time' => DB::raw('delivery_time + ' . random_int(20, 40))]);
            }

        } catch (\Throwable) {
            $this->order->update(['delivery_time' => DB::raw('delivery_time + ' . random_int(20, 40))]);
        }
    }
}
