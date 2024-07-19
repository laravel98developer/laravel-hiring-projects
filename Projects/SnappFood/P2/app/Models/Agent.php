<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'firstname',
        'lastname',
    ];

    public function delayReports(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(DelayReport::class, 'agent_id', 'id');
    }
}
