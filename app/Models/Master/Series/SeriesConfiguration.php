<?php

// app/Models/Master/Series/SeriesConfiguration.php
namespace App\Models\Master\Series;

use Illuminate\Database\Eloquent\Model;
use App\Models\Master\ProductKeys\ProductType;

class SeriesConfiguration extends Model
{
    protected $table = 'elitevw_master_series_configurations';

    protected $fillable = ['series_type', 'category', 'image', 'product_type_id'];

    // many-to-many via pivot
   public function productTypes()
{
    return $this->belongsToMany(
        \App\Models\Master\ProductKeys\ProductType::class,
        'elitevw_master_series_configuration_product_type', // pivot table
        'series_configuration_id',                          // this model's FK
        'product_type_id'                                   // related model's FK
    )->withTimestamps();
}


    // optional direct FK
    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }
}
