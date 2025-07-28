<?php

namespace App\Models\BillOfMaterials\Menu;

use Illuminate\Database\Eloquent\Model;

class Pullers extends Model
{
    protected $table = 'elitevw_bom_menu_pullers';
    protected $fillable = ['name'];
}