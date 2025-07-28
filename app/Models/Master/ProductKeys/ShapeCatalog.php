<?php

namespace App\Models\Master\ProductKeys;

use Illuminate\Database\Eloquent\Model;

class ShapeCatalog extends Model
{
    protected $table = 'elitevw_master_productkeys_shapecatalog';

    protected $fillable = ['catalog_number', 'priority', 'manufacturer_system'];
}
