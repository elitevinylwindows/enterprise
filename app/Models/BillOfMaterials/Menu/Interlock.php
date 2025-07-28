<?php

namespace App\Models\BillOfMaterials\Menu;

use Illuminate\Database\Eloquent\Model;

class Interlock extends Model
{
    protected $table = 'elitevw_bom_menu_interlock';
    protected $fillable = ['name'];
}