<?php

namespace App\Models\Master\Products;

use Illuminate\Database\Eloquent\Model;

class ProductClasses extends Model
{
    
protected $table = 'elitevw_master_products_product_classes'; 

    protected $fillable = ['product_class', 'name', 'description'];
}
