<?php

namespace App\Helpers;

use App\Dtos\OrderStoreDto;
use App\Http\Requests\OrderStoreRequest;

class DtoHelper
{
    public static function requestToOrderStoreDto(
        OrderStoreRequest $request
    ): OrderStoreDto {
        return new OrderStoreDto(
            $request->input('from_destination_latitude'),
            $request->input('from_destination_longitude'),
            $request->input('to_destination_latitude'),
            $request->input('to_destination_longitude'),
            $request->input('address'),
            $request->attributes->get('supplier_id'),
            $request->input('supplier_name'),
            $request->input('supplier_phone'),
            $request->input('receiver_name'),
            $request->input('receiver_phone'),
        );
    }
}
