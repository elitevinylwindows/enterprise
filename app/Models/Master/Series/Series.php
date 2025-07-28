<?php

namespace App\Models\Master\Series;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $table = 'elitevw_master_series';
    protected $fillable = ['series'];
    public function configurations()
{
    return $this->hasMany(\App\Models\Master\Series\SeriesType::class, 'series_id');
}

}
