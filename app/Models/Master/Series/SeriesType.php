<?php

namespace App\Models\Master\Series;

use Illuminate\Database\Eloquent\Model;

class SeriesType extends Model
{
    // Adjust if your actual table name differs
    protected $table = 'elitevw_master_series_types';

    protected $fillable = [
        'series_id',
        'series_type',
    ];

    public function series()
    {
        return $this->belongsTo(Series::class, 'series_id');
    }
}
