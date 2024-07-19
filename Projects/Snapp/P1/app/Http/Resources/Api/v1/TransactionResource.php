<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'account_number' => $this->sender->bankAccount->account_number,
            'amount' => $this->amount,
            'created_at' => $this->created_at->toDateTimeString(),
            'status' => $this->status->displayTitle(),
        ];
    }
}
