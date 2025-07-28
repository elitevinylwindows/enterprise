<?php

namespace App\Models\Master\Products\ProductMaster;

use Illuminate\Database\Eloquent\Model;

class Materials extends Model
{
    protected $table = 'elitevw_master_products_materials';
    protected $fillable = ['product_id', 'product_code', 'name', 'description', 'product_type', 'manufacturer_system'];
}
