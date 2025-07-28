<?php

namespace App\Models\Master\Products\ProductMaster;

use Illuminate\Database\Eloquent\Model;

class Units extends Model
{
    protected $table = 'elitevw_master_products_units';
    protected $fillable = ['product_id', 'product_code', 'name', 'description', 'product_type', 'manufacturer_system'];
}
