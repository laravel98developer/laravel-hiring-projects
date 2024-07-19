<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class DeliveryChecker
{
    public function handle(Request $request, Closure $next): Response
    {
        if (
            $request->hasHeader('checker')
            && Str::of($request->header('checker'))->startsWith('delivery-')
            && is_numeric(Str::of($request->header('checker'))->afterLast('delivery-')->value())
        ) {
            $request->attributes->set(
                'delivery_id',
                (int) Str::of($request->header('checker'))->afterLast('delivery-')->value()
            );
            return $next($request);
        }

        return response()->json()->setStatusCode(Response::HTTP_FORBIDDEN);
    }
}
