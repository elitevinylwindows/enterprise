<?php

namespace App\Models\Master\Prices;

use Illuminate\Database\Eloquent\Model;

class Markup extends Model
{
    protected $table = 'elitevw_master_markup';

    protected $fillable = [
        'series_id',
        'percentage',
        'is_locked'
    ];

    public function series()
    {
        return $this->belongsTo(\App\Models\Master\Series\Series::class, 'series_id');
    }
}
