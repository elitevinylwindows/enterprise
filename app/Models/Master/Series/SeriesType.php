<?php

namespace App\Models\Master\Series;

use Illuminate\Database\Eloquent\Model;

class SeriesType extends Model
{
    protected $table = 'elitevw_master_series_types';

    protected $fillable = [
        'series_id',
        'series_type',
    ];

    public function series()
    {
        return $this->belongsTo(\App\Models\Master\Series\Series::class);
    }

    // Many Product Types (array)
    public function productTypes()
    {
        return $this->belongsToMany(
            \App\Models\Master\ProductKeys\ProductType::class,
            'elitevw_master_series_type_product_type', // pivot
            'series_type_id',
            'product_type_id'
        )->withTimestamps();
    }
}
