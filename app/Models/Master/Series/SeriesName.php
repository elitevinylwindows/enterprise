<?php

namespace App\Models\Master\Series;

use Illuminate\Database\Eloquent\Model;

class SeriesName extends Model
{
    protected $table = 'elitevw_master_series_names';
    protected $fillable = ['series_id', 'series_name'];
    
    public function series()
{
    return $this->belongsTo(Series::class);
}

}
