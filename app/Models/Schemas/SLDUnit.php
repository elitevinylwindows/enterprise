<?php

namespace App\Models\Schemas;

use Illuminate\Database\Eloquent\Model;

class SLDUnit extends Model
{
    protected $table = 'elitevw_schema_sldunit';
    protected $fillable = [
        'schema_id',
        'lam',
        'feat1',
        'feat2',
        'feat3',
        'acid_edge',
        'solar_cool',
    ];
}
