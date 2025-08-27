<?php

namespace App\Models\Schemas;

use Illuminate\Database\Eloquent\Model;

class GSCOSLDUnit extends Model
{
    protected $table = 'elitevw_schema_gscosldunit';
    protected $fillable = ['schema_id', 'clr_clr', 'le3_clr', 'le3_clr_le3', 'le3_lam', 'clr_lam', 'color_multi', 'base_multi', 'feat1', 'feat2', 'feat3', 'status', 'product_id',
        'description',
        'product_code'];
}
