<?php

namespace App\Contracts\Validate;

use App\Models\Order;
use Closure;

interface StoreDelayReport
{
    public function handle(Order $order, Closure $next);
}
