<?php
namespace App\Models\Master\ProductKeys;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    // Use YOUR actual table name (from your schema you shared)
    protected $table = 'elitevw_master_productkeys_producttypes';

    protected $fillable = [
        'product_type','series','description',
        'material_type','glazing_bead_position','product_id'
    ];

    // ⬇️ Inverse many-to-many back to SeriesConfiguration
    public function seriesConfigurations()
    {
        return $this->belongsToMany(
            \App\Models\Master\Series\SeriesConfiguration::class,
            'elitevw_master_series_configuration_product_type', // pivot
            'product_type_id',                                  // this model's FK
            'series_configuration_id'                           // related model's FK
        )->withTimestamps();
    }
}
