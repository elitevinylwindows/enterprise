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
        'id', 
        'station',  // "Station #"
        'description',
        'status',
        'ui_key',           // 'active' | 'inactive'
    ];

    protected $casts = [
        'station' => 'string',
    ];

    public function users()
{
    return $this->hasMany(\App\Models\User::class);
}
}
