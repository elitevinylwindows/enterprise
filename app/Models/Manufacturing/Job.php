<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use SoftDeletes;

    // Adjust if your actual table name differs
    protected $table = 'elitevw_manufacturing_jobs';

    protected $fillable = [
        'order_id',
        'station',
        'status',        // e.g. unprocessed, processed, tempered, draft, active
        'description',
        'priority',      // optional integer (for prioritize feature)
    ];

    protected $casts = [
        'priority' => 'integer',
    ];

    /** Relationship: job belongs to an order with job_order_number */
    public function order()
    {
        // Adjust the related class/table/keys if your Order model differs
        return $this->belongsTo(\App\Models\Manufacturing\Order::class, 'order_id');
    }
}
