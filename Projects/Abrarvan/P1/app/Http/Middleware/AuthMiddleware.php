<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        abort_if(!$request->has('phone'), Response::HTTP_NOT_FOUND);
        abort_if(!User::query()->wherePhone($request->phone)->first(), Response::HTTP_NOT_FOUND);

        return $next($request);
    }
}
