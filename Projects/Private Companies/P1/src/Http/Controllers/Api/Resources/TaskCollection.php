<?php

namespace AliSalehi\Task\Http\Controllers\Api\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'result' => TaskResource::collection($this->collection),
            'meta' => [
                'pagination' => [
                    'current_page'  => $this->currentPage(),
                    'last_page'     => $this->lastPage(),
                    'per_page'      => $this->perPage(),
                    'total'         => $this->total(),
                    'next_page_url' => $this->nextPageUrl(),
                    'prev_page_url' => $this->previousPageUrl(),
                ]
            ]
        ];
    }
}
