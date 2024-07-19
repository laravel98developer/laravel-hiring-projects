<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class MartinChecker
{
    public function handle(Request $request, Closure $next): Response
    {
        if (
            $request->hasHeader('checker')
            && Str::of($request->header('checker'))->startsWith('martin-')
            && is_numeric(Str::of($request->header('checker'))->afterLast('martin-')->value())
        ) {
            $request->attributes->set(
                'martin_id',
                (int) Str::of($request->header('checker'))->afterLast('martin-')->value()
            );
            return $next($request);
        }

        return response()->json()->setStatusCode(Response::HTTP_FORBIDDEN);
    }
}
