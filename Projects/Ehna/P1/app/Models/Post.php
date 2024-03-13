<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use JeroenG\Explorer\Application\Explored;
use Laravel\Scout\Searchable;

class Post extends Model implements Explored
{
    use HasFactory, SoftDeletes, Searchable;

    protected $guarded = [
        'id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function searchableAs(): string
    {
        return 'posts_index';
    }

    public function mappableAs(): array
    {
        return [
            'id' => 'keyword',
            'user_id' => 'long',
            'title' => 'string',
            'description' => 'string',
            'body' => 'text',
            'created_at' => 'date',
            'updated_at' => 'updated_at',
        ];
    }
}
