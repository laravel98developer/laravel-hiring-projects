<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderFilterResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var Order $this */
        return [
            'mobile_number' => $this->mobile_number,
            'national_code' => $this->national_code,
            'amount'        => $this->amount,
            'status'        => $this->status ? 'success' : 'failed',
        ];
    }
}
