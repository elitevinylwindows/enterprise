<?php

namespace App\Models\BillOfMaterials\Menu;

use Illuminate\Database\Eloquent\Model;

class Snapping extends Model
{
    protected $table = 'elitevw_bom_menu_snapping';
    protected $fillable = ['name', 'color'];
}
