<?php

namespace App\Models\Master\ProductKeys;

use Illuminate\Database\Eloquent\Model;

class ManufacturerSystem extends Model
{
    protected $table = 'elitevw_master_productkeys_manufacturersystems';

    protected $fillable = ['manufacturer_system', 'skz', 'description'];
}
