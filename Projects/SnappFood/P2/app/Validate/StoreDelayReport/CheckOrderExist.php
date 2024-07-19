<?php

namespace App\Validate\StoreDelayReport;

use App\Contracts\Validate\StoreDelayReport;
use App\Exceptions\OrderNotFound;
use App\Models\Order;
use Closure;

class CheckOrderExist implements StoreDelayReport
{
    public function handle(Order $order, Closure $next)
    {
        throw_if(empty($order), OrderNotFound::class);

        return $next($order);
    }
}
