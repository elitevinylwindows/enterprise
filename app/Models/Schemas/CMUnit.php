<?php

namespace App\Models\Schemas;

use Illuminate\Database\Eloquent\Model;

class CMUnit extends Model
{
    protected $table = 'elitevw_schema_cmunit';
    protected $fillable = [
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
        'twole3_oneclr_temp',
        'sta_grd',
        'tpi',
        'tpo',
        'acid_edge',
        'solar_cool',
        'product_id',
        'description',
        'product_code'
    ];
}
