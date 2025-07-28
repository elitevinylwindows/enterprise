<?php

namespace App\Models\BillOfMaterials\Menu;

use Illuminate\Database\Eloquent\Model;

class DoubleTape extends Model
{
    protected $table = 'elitevw_bom_menu_doubletape';
    protected $fillable = ['name', 'color'];
}
