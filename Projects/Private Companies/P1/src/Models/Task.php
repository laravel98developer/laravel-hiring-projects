<?php

namespace AliSalehi\Task\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;
    
    const Id = 'id';
    const TRUE = '1';
    const FALSE = '0';
    const TITLE = 'title';
    const USER_ID = 'user_id';
    const DUE_DATE = 'due_date';
    const ATTACHMENT = 'attachment';
    const DESCRIPTION = 'description';
    const IS_COMPLETED = 'is_completed';
    const IS_HIGHLIGHTED = 'is_highlighted';
    
    public static array $IS_COMPLETED = [
        'true'  => self::TRUE,
        'false' => self:: FALSE,
    ];
    
    protected $fillable = [
        self::USER_ID,
        self::TITLE,
        self::DESCRIPTION,
        self::ATTACHMENT,
        self::DUE_DATE,
        self::IS_COMPLETED,
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(config('task.user.model', User::class));
    }
}
