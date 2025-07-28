<?php

namespace App\Models\BillOfMaterials\Menu;

use Illuminate\Database\Eloquent\Model;

class WaterFlow extends Model
{
    protected $table = 'elitevw_bom_menu_waterflow';
    protected $fillable = ['name', 'color'];
}
