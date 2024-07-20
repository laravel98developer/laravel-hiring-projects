<?php

namespace Modules\Article\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Article\Database\Factories\ArticleFactory;

class Article extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['title', 'content', 'user_id', 'publication_date', 'publication_status'];

    protected static function newFactory()
    {
        return ArticleFactory::new();
    }

    /**
     * Get the Article associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
