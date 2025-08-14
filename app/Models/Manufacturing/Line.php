<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Line extends Model
{
    use SoftDeletes;

    // If your table name is different, set it here:
    // protected $table = 'manufacturing_lines';

    protected $fillable = [
        'line',        // string, required
        'description', // text, nullable
        'status',      // 'active' | 'inactive'
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];
}
