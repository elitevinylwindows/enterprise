<?php

namespace App\Models\Master\Products;

use Illuminate\Database\Eloquent\Model;

class SealingAssignment extends Model
{
    protected $table = 'elitevw_master_products_sealing_assignment';

    protected $fillable = ['rebate_depth', 'installation_thickness_from', 'installation_thickness_to', 'style', 'profile_system', 'condition', 'comment', 'area', 'evaluation', 'manufacturer_system', 'sort_order'];
}
