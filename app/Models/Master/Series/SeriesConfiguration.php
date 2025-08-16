<?php

namespace App\Models\Master\Series;

use Illuminate\Database\Eloquent\Model;
use App\Models\Master\ProductKeys\ProductType;

class SeriesConfiguration extends Model
{
    protected $table = 'elitevw_master_series_configurations';

    protected $fillable = [
        'series_type',      // e.g. "XO", "PW6-32"
        'category',
        'image',
        'product_type_id',  // SINGLE FK
    ];

    // Each configuration is for ONE product type
    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }
}
