<?php

namespace App\Models\BillOfMaterials\Menu;

use Illuminate\Database\Eloquent\Model;

class SashReinforcement extends Model
{
    protected $table = 'elitevw_bom_menu_sashreinforcement';
    protected $fillable = ['name', 'size'];
}
