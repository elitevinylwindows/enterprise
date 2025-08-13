<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobPool extends Model
{
    use SoftDeletes;

    protected $table = 'elitevw_manufacturing_job_pool';

    protected $fillable = [
        'job_order_number',
        'series',
        'qty',
        'line',
        'delivery_date',
        'type',
        'production_status',
        'entry_date',
        'last_transaction_date',
    ];

    protected $casts = [
        'qty' => 'integer',
        'delivery_date' => 'date',
        'entry_date' => 'date',
        'last_transaction_date' => 'datetime',
    ];

    // Quick helpers for filtering by status
    public function scopeProductionStatus($query, ?string $status)
    {
        if (!$status || $status === 'all') return $query;
        if ($status === 'deleted') return $query->onlyTrashed();

        return $query->where('production_status', $status);
    }
}
