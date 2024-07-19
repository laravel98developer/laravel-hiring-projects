<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DelayReport extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'order_id',
        'agent_id',
        'delay_minute',
    ];

    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function agent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Agent::class, 'agent_id', 'id');
    }

    public function delayReportStatuses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DelayReportStatus::class, 'delay_report_id', 'id');
    }

    public function delayReportStatus(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(CurrentDelayReportStatus::class, 'delay_report_id', 'id');
    }
}
