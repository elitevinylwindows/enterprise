<?php

namespace App\Models\BillOfMaterials\Menu;

use Illuminate\Database\Eloquent\Model;

class LockCover extends Model
{
    protected $table = 'elitevw_bom_menu_lockcover';
    protected $fillable = ['name', 'color'];
}
