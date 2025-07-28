<?php

namespace App\Models\Master\ProductKeys;

use Illuminate\Database\Eloquent\Model;

class ProductSystem extends Model
{
    protected $table = 'elitevw_master_productkeys_productsystems';

    protected $fillable = ['product_system', 'description'];
}
