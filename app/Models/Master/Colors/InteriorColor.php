<?php

namespace App\Models\Master\Colors;

use Illuminate\Database\Eloquent\Model;

class InteriorColor extends Model
{
        protected $table = 'elitevw_master_colors_interior_colors';

    protected $fillable = ['name', 'code'];
}
