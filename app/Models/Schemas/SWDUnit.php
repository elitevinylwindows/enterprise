<?php

namespace App\Models\Schemas;

use Illuminate\Database\Eloquent\Model;

class SWDUnit extends Model
{
    protected $table = 'elitevw_schema_swdunit';
    protected $fillable = [
        'schema_id',
        'lam',
        'feat1',
        'feat2',
        'feat3',
        'product_id',
        'description',
        'product_code'
    ];
}
