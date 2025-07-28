<?php

namespace App\Models\Schemas;

use Illuminate\Database\Eloquent\Model;

class HSUnit extends Model
{
    protected $table = 'elitevw_schema_hsunit';
    protected $fillable = [
        'schema_id',
        'retrofit',
        'nailon',
        'block',
        'le3_clr',
        'clr_clr',
        'le3_lam',
        'le3_clr_le3',
        'clr_temp',
        '1le3_1clrtemp',
        '2le3_1clrtemp',
        'lam_temp',
        'obs',
        'feat2',
        'feat3',
        'sta_grd',
        'tpi',
        'tpo',
        'acid_etch',
        'solar_cool',
        'solar_cool_g',
    ];
}
