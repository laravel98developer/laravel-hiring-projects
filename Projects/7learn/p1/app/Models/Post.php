<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title','content','status'];

    public function tags()
    {
        return $this->belongsTomany(Tag::class);
    }


}
