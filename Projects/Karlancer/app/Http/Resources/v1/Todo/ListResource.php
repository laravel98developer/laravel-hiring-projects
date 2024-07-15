<?php

namespace App\Http\Resources\v1\Todo;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => Str::substr($this->description, 0, 30) . "...",
            "description" => $this->description,
            "done" => $this->done,
            "due_date" => $this->due_date,
            "category_id" => $this->category_id,
            "category_name" => $this->category_name,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
