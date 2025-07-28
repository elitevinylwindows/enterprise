<?php

namespace App\Models\Master\Products\ProductMaster;

use Illuminate\Database\Eloquent\Model;

class HardwareVariant extends Model
{
    protected $table = 'elitevw_master_products_hardwarevariant';
    protected $fillable = ['product_id', 'product_code', 'name', 'description', 'product_type', 'manufacturer_system', 'hardware_type', 'type_class'];
}
