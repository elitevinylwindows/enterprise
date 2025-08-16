<?php
namespace App\Models\Master\Series;

use Illuminate\Database\Eloquent\Model;

class SeriesConfiguration extends Model
{
    protected $table = 'elitevw_master_series_configurations';

    protected $fillable = ['series_type', 'category', 'image', 'product_type_id'];

    // ⬇️ Correct many-to-many to ProductType via the *configuration* pivot
    public function productTypes()
    {
        return $this->belongsToMany(
            \App\Models\Master\ProductKeys\ProductType::class,
            'elitevw_master_series_configuration_product_type', // pivot table
            'series_configuration_id',                          // this model's FK on pivot
            'product_type_id'                                   // related model's FK on pivot
        )->withTimestamps();
    }
}
