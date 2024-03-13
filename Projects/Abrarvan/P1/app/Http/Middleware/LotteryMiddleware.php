<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class LotteryMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // check to prevent duplicating request from a user
        $caheKey = env('GIFT_CODE_USER_DATA_CACHE_KEY').'_'.$request->phone;
        abort_if(Cache::has($caheKey), Response::HTTP_NOT_FOUND);

        return $next($request);
    }
}
