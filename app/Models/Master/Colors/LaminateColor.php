<?php

namespace App\Models\Master\Colors;

use Illuminate\Database\Eloquent\Model;

class LaminateColor extends Model {
    protected $table = 'elitevw_master_colors_laminate_colors';
        protected $fillable = ['name', 'code'];

}
