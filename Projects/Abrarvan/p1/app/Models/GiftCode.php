<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GiftCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'price',
    ];
}
