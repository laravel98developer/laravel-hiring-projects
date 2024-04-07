<?php

namespace App\Http\Middleware;

use App\Services\ProductReviewService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductIsReviewable
{

    protected $productReviewService;

    public function __construct(ProductReviewService $productReviewService)
    {
        $this->productReviewService = $productReviewService;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure $next (\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param ProductReviewService $productReviewService
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$this->productReviewService->checkIsReviewable($request->product_id)){
            return response()->error(
                __('messages.forbidden'),
                Response::HTTP_FORBIDDEN
            );
        }
        return $next($request);
    }
}
