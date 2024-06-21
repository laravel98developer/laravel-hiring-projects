<?php

namespace App\Models;

use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $mobile_number
 * @property string $national_code
 * @property int $amount
 * @property bool $status
 */
class Order extends Model
{
    use HasFactory;
    protected $guarded=[];

    protected static function newFactory(): OrderFactory
    {
        return OrderFactory::new();
    }
}



