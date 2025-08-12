<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use SoftDeletes;

    protected $table = 'elitevw_manufacturing_jobs';

    protected $fillable = [
        'order_id', 'status', 'priority', 'station', 'description',
    ];

    protected $casts = [
        'priority' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(\App\Models\Manufacturing\Order::class, 'order_id');
    }
}
