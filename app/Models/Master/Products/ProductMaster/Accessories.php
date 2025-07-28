<?php

namespace App\Models\Master\Products\ProductMaster;

use Illuminate\Database\Eloquent\Model;

class Accessories extends Model
{
    protected $table = 'elitevw_master_products_accessories';

    protected $fillable = [
        'product_id', 'product_code', 'name', 'description', 'product_type',
        'manufacturer_system', 'product_class', 'color_management',
        'product_code_template', 'sort_order'
    ];
}
