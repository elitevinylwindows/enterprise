<?php

namespace App\Models\Manufacturing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Station extends Model
{
    use SoftDeletes;

    // Adjust if your table name differs
    protected $table = 'elitevw_manufacturing_stations';

    protected $fillable = [
        'station_number',   // "Station #"
        'description',
        'status',           // 'active' | 'inactive'
    ];

    protected $casts = [
        'station_number' => 'string',
    ];
}
