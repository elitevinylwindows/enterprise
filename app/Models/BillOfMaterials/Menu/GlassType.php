<?php

namespace App\Models\BillOfMaterials\Menu;

use Illuminate\Database\Eloquent\Model;

class GlassType extends Model
{
    protected $table = 'elitevw_bom_menu_glasstype';

    protected $fillable = [
        'name',
        'thickness_3_1_mm',
        'thickness_3_9_mm',
        'thickness_4_7_mm',
        'thickness_5_7_mm'
    ];
}
