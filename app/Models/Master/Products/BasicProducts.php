<?php

namespace App\Models\Master\Products;

use Illuminate\Database\Eloquent\Model;

class BasicProducts extends Model
{
    protected $table = 'elitevw_master_products_basic_products';
    protected $fillable = ['product_class', 'name', 'product_code', 'description'];
}
