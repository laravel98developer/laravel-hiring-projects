<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;


class Product extends Model
{
    use HasFactory;

    protected $fillable = [
      "name",
      "price",
      "inventory"
    ];

}
