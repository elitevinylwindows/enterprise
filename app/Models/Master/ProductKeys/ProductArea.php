<?php

namespace App\Models\Master\ProductKeys;

use Illuminate\Database\Eloquent\Model;

class ProductArea extends Model
{
    protected $table = 'elitevw_master_productkeys_productareas';

    protected $fillable = ['product_area', 'description', 'product_types'];
}
