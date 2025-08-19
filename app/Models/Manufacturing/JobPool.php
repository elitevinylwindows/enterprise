<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobPool extends Model
{
    use SoftDeletes;

    protected $table = 'elitevw_manufacturing_job_pool';

    protected $fillable = [
        'order_id',
        'order_item_id',
        'job_order_number',
        'series',
        'qty',
        'line',
        'delivery_date',
        'type',
        'production_status',
        'entry_date',
        'last_transaction_date',
        'customer_number',
        'customer_name',
        'color',
        'frame_type',
        'profile'
        
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

    public function order()
    {
        return $this->belongsTo(\App\Models\Sales\Order::class, 'order_id');
    }

    public function item()
    {
        return $this->belongsTo(\App\Models\Sales\OrderItem::class, 'order_item_id');
    }
    
    public function customer()
    {
        return $this->belongsTo(\App\Models\Master\Customers\Customer::class, 'customer_number', 'customer_number');
    }
