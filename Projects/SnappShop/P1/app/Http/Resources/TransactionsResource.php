<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'card_number' => $this->card->card_number,
            'destination_card_number' => $this->destinationCard->card_number,
            'amount' => $this->amount,
            'created_at' => $this->created_at
        ];
    }
}
