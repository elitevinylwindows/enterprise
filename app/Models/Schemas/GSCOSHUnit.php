<?php

namespace App\Models\Schemas;

use Illuminate\Database\Eloquent\Model;

class GSCOSHUnit extends Model
{
    protected $fillable = ['schema_id', 'retrofit', 'nailon', 'block', 'le3_clr', 'le3_lam', 'clr_temp', 'onele3_oneclr_temp', 'lam_temp', 'feat1', 'feat2', 'feat3', 'clr_clr', 'le3_clr_le3', 'twole3_oneclr_temp', 'sta_grid', 'tpi', 'tpo', 'status'];
}
