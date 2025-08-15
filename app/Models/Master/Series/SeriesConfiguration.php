<?php

namespace App\Models\Master\Series;

use Illuminate\Database\Eloquent\Model;

class SeriesConfiguration extends Model
{
    protected $table = 'elitevw_master_series_configurations';

    protected $fillable = ['series_type'];

    public function productTypes()
    {
        return $this->belongsToMany(
            \App\Models\Master\ProductKeys\ProductType::class,
            'elitevw_master_series_type_product_type', // pivot table name
            'series_type_id',
            'product_type_id'
        )->withTimestamps();
    }
}
