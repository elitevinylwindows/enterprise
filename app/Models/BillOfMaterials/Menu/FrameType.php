<?php

namespace App\Models\BillOfMaterials\Menu;

use Illuminate\Database\Eloquent\Model;

class FrameType extends Model
{
    protected $table = 'elitevw_bom_menu_frametype';
    protected $fillable = ['name', 'color'];
}
