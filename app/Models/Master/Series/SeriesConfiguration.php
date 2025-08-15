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
            ProductType::class,
            'elitevw_master_series_type_product_type',
            'series_type_id',
            'product_type_id'
        )->withTimestamps();
    }

    // optional direct FK
    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }
}
