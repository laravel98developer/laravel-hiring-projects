<?php

namespace App\Foundation\Http\Resources\Json;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;

class BaseResourceCollection extends ResourceCollection
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        if ($this->resource instanceof AbstractPaginator) {
            return (new CustomPaginatedResourceResponse($this))->toResponse($request);
        }

        return parent::toResponse($request);
    }
}
