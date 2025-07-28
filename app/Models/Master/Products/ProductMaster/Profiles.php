<?php

namespace App\Models\Master\Products\ProductMaster;

use Illuminate\Database\Eloquent\Model;

class Profiles extends Model
{
    protected $table = 'elitevw_master_products_profiles';
    protected $fillable = ['product_id', 'product_code', 'name', 'description', 'product_type', 'manufacturer_system', 'type', 'profile_system', 'basic_profile_system', 'color_management', 'wood_scantling'];
}
