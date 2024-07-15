<?php

namespace App\Http\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;

class CustomLengthAwarePaginator extends LengthAwarePaginator
{
    public function toArray()
    {
        return [
            'current_page' => $this->currentPage(),
            'items' => $this->items->toArray(),
            'first_page_url' => $this->url(1),
//            'from' => $this->firstItem(),
//            'last_page' => $this->lastPage(),
            'last_page_url' => $this->url($this->lastPage()),
//            'links' => $this->linkCollection()->toArray(),
//            'next_page_url' => $this->nextPageUrl(),
//            'path' => $this->path(),
            'per_page' => $this->perPage(),
//            'prev_page_url' => $this->previousPageUrl(),
//            'to' => $this->lastItem(),
            'total' => $this->total(),
        ];
    }
}
