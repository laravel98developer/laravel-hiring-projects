<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $firstname
 * @property mixed $lastname
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class AgentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
