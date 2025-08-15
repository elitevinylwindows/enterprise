<?php

// App/Models/Master/Series/SeriesConfiguration.php
namespace App\Models\Master\Series;

use Illuminate\Database\Eloquent\Model;

class SeriesConfiguration extends Model
{
    protected $table = 'elitevw_master_series_configurations';

    protected $fillable = [
        'series_type', 'category', 'image', 'product_type_id',
    ];

    // Each configuration belongs to one product type (via the column in your table)
    public function productType()
    {
        return $this->belongsTo(\App\Models\Master\ProductKeys\ProductType::class, 'product_type_id');
    }

    // ❌ REMOVE any belongsToMany() here that references:
    // elitevw_master_series_type_product_type (series_type_id/product_type_id)
}
