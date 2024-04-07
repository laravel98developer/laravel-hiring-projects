<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "o_latitude" => $this->origin_latitude,
            "o_longitude" => $this->origin_longitude,
            "o_firstname" => $this->origin_firstname,
            "o_lastname" => $this->origin_lastname,
            "o_address" => $this->origin_address,
            "o_phone" => $this->origin_phone,
            "d_latitude" => $this->destination_latitude,
            "d_longitude" => $this->destination_longitude,
            "d_firstname" => $this->destination_firstname,
            "d_lastname" => $this->destination_lastname,
            "d_address" => $this->destination_address,
            "d_phone" => $this->destination_phone,
        ];
    }
}
