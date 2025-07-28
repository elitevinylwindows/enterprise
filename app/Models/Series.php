<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $table = 'elitevw_sr_series';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'bom_json',
    ];

    protected $casts = [
        'bom_json' => 'array',
    ];
    
    public function groups()
{
    return $this->belongsToMany(FormOptionGroup::class, 'elitevw_sr_series_group', 'series_id', 'group_id');
}

}
