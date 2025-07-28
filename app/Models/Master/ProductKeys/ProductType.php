<?php

namespace App\Models\Master\ProductKeys;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $table = 'elitevw_master_productkeys_producttypes';

    protected $fillable = ['product_type', 'description', 'material_type', 'glazing_bead_position'];
}
