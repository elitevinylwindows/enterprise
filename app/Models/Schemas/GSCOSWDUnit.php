<?php

namespace App\Models\Schemas;

use Illuminate\Database\Eloquent\Model;

class GSCOSWDUnit extends Model
{
    protected $fillable = ['schema_id', 'clr_clr', 'le3_clr', 'le3_clr_le3', 'le3_lam', 'clr_lam', 'coror_mulit', 'base_mulit', 'feat1', 'feat2', 'feat3', 'status', 'product_id',
        'description',
        'product_code'];
}
