<?php

namespace App\Validate\StoreDelayReport;

use App\Contracts\Validate\StoreDelayReport;
use App\Exceptions\OrderDoesNotHaveDelay;
use App\Models\Order;
use Carbon\Carbon;
use Closure;

class CheckOrderHasDelay implements StoreDelayReport
{
    public function handle(Order $order, Closure $next)
    {
        throw_if($order->delivery_time > Carbon::now(), OrderDoesNotHaveDelay::class);

        return $next($order);
    }
}
