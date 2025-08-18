<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Line extends Model
{
    use SoftDeletes;

   
    protected $table = 'elitevw_manufacturing_lines';
    protected $fillable = [
        'line',        // string, required
        'description', // text, nullable
        'status',      // 'active' | 'inactive'
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    
}
