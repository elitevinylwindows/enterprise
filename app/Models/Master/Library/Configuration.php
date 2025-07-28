<?php

namespace App\Models\Master\Library;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $table = 'elitevw_master_series_types';

    protected $fillable = [
        'series_id',
        'series_type',
        'category',
        'image'
    ];
}
