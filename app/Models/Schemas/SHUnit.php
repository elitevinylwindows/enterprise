<?php

namespace App\Models\Schemas;

use Illuminate\Database\Eloquent\Model;

class SHUnit extends Model
{
    protected $table = 'elitevw_schema_shunit';
    
    protected $fillable = [
        'id',
        'product_id',
        'product_code',
        'product_class',
        'description',
        'schema_id',
        'retrofit',
        'nailon',
        'block',
        'le3_clr',
        'le3_lam',
        'clr_temp',
        'le3_temp',
        'lam_temp',
        'feat1',
        'feat2',
        'feat3',
        'clr_clr',
        'le3_clr_le3',
        'le3_combo',
        'sta_grid',
        'tpi',
        'tpo',
        'acid_edge',
        'solar_cool',
        
    ];

}
