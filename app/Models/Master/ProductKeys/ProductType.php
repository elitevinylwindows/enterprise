<?php

// app/Models/Master/ProductKeys/ProductType.php
namespace App\Models\Master\ProductKeys;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $table = 'elitevw_master_productkeys_producttypes';

    protected $fillable = [
        'product_type', 'series', 'description',
        'material_type', 'glazing_bead_position', 'product_id',
    ];

    // PIVOT relation (many-to-many)
    public function seriesConfigurations()
    {
        return $this->belongsToMany(
            \App\Models\Master\Series\SeriesConfiguration::class,
            'elitevw_master_series_type_product_type', // pivot
            'product_type_id',                         // pivot FK -> this model
            'series_type_id'                           // pivot FK -> SeriesConfiguration
        )->withTimestamps();
    }

    // DIRECT FK (configs.product_type_id) — optional, but you have this column
    public function directSeriesConfigurations()
    {
        return $this->hasMany(
            \App\Models\Master\Series\SeriesConfiguration::class,
            'product_type_id', // on configs table
            'id'               // local PK here
        );
    }
}
