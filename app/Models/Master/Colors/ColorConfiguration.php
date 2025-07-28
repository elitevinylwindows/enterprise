<?php

namespace App\Models\Master\Colors;

use Illuminate\Database\Eloquent\Model;

class ColorConfiguration extends Model
{
    protected $table = 'elitevw_master_colors_color_configurations';
protected $fillable = [
    'name',
    'code',
];

}
