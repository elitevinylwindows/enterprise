<?php

namespace App\Models\BillOfMaterials\Menu;

use Illuminate\Database\Eloquent\Model;

class LockType extends Model
{
    protected $table = 'elitevw_bom_menu_locktype';
    protected $fillable = ['name'];
}
