<?php

namespace App\Models\BillOfMaterials\Menu;

use Illuminate\Database\Eloquent\Model;

class RollerTrack extends Model
{
    protected $table = 'elitevw_bom_menu_rollertrack';
    protected $fillable = ['name', 'color'];
}
