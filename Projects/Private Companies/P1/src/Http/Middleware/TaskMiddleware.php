<?php

namespace AliSalehi\Task\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }
}
