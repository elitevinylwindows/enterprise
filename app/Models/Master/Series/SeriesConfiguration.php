<?php

namespace App\Models\Master\Series;

use Illuminate\Database\Eloquent\Model;

class SeriesConfiguration extends Model
{
    protected $table = 'elitevw_master_series_configurations';

    protected $fillable = ['series_type', 'category', 'image', 'product_type_id'];

    // ✅ CORRECT relation to ProductType via the *configuration* pivot
    public function productTypes()
    {
        return $this->belongsToMany(
            \App\Models\Master\ProductKeys\ProductType::class,
            'elitevw_master_series_configuration_product_type', // <-- table name
            'series_configuration_id',                          // <-- FK to THIS model
            'product_type_id'                                   // <-- FK to ProductType
        )->withTimestamps();
    }

    // optional direct FK
    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }
}
