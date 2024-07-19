<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class SupplyChecker
{
    public function handle(Request $request, Closure $next): Response
    {
        if (
            $request->hasHeader('checker')
            && Str::of($request->header('checker'))->startsWith('supply-')
            && is_numeric(Str::of($request->header('checker'))->afterLast('supply-')->value())
        ) {
            $request->attributes->set(
                'supplier_id',
                (int) Str::of($request->header('checker'))->afterLast('supply-')->value()
            );
            return $next($request);
        }

        return response()->json()->setStatusCode(Response::HTTP_FORBIDDEN);
    }
}
