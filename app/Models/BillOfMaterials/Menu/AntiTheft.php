<?php

namespace App\Models\BillOfMaterials\Menu;

use Illuminate\Database\Eloquent\Model;

class AntiTheft extends Model
{
    protected $table = 'elitevw_bom_menu_antitheft';
    protected $fillable = ['name'];
}