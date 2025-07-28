<?php

namespace App\Models\BillOfMaterials\Menu;

use Illuminate\Database\Eloquent\Model;

class WarningLabel extends Model
{
    protected $table = 'elitevw_bom_menu_warninglabel';
    protected $fillable = ['name'];
}