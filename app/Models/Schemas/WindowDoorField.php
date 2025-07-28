<?php

namespace App\Models\Schemas;

use Illuminate\Database\Eloquent\Model;

class WindowDoorField extends Model
{
    protected $fillable = ['schema_id', 'clr_temp', 'le3_temp', 'lam_temp', 'feat1', 'feat2', 'feat3', 'sta_grid', 'le3_clr_temp_combo', 'status'];
}
