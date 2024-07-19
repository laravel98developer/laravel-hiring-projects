<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChangeFaNumbersToEn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // get input data and put changed characters in request
        $input = $request->all();

        $input['card_number'] = fatoEnNumeric($input['card_number']);
        $input['destination_card_number'] = fatoEnNumeric($input['destination_card_number']);
        $input['amount'] = fatoEnNumeric($input['amount']);
    
        $request->replace($input);

        return $next($request);
    }
}
