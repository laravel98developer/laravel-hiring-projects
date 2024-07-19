<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_destination_latitude',
        'from_destination_longitude',
        'to_destination_latitude',
        'to_destination_longitude',
        'address',
        'supplier_id',
        'supplier_name',
        'supplier_phone',
        'receiver_name',
        'receiver_phone',
        'status',
        'delivery_id',
    ];

    protected $casts = [
        'status' => OrderStatusEnum::class,
        'supplier_id' => 'int',
        'delivery_id' => 'int',
        'from_destination_latitude' => 'double',
        'from_destination_longitude' => 'double',
        'to_destination_latitude' => 'double',
        'to_destination_longitude' => 'double',
    ];
}
