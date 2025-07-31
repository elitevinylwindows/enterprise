<?php

namespace App\Models\Master\Series;

use Illuminate\Database\Eloquent\Model;
use App\Models\Master\ProductKeys\ProductType;

class SeriesType extends Model
{
    protected $table = 'elitevw_master_series_types';

    protected $fillable = [
        'series_id',
        'series_type',
        'product_type_id',
    ];

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }
}
