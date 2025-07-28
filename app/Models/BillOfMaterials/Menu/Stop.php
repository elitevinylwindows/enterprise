<?php

namespace App\Models\BillOfMaterials\Menu;

use Illuminate\Database\Eloquent\Model;

class Stop extends Model
{
    protected $table = 'elitevw_bom_menu_stop';
    protected $fillable = ['name', 'color'];
}
