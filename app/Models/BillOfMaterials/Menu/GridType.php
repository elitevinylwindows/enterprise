<?php

namespace App\Models\BillOfMaterials\Menu;

use Illuminate\Database\Eloquent\Model;

class GridType extends Model
{
    protected $table = 'elitevw_bom_menu_gridtype';
    protected $fillable = ['name', 'color'];
}
