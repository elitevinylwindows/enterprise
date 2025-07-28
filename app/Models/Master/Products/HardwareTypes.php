<?php

namespace App\Models\Master\Products;

use Illuminate\Database\Eloquent\Model;

class HardwareTypes extends Model
{
    protected $table = 'elitevw_master_products_hardware_types';

    protected $fillable = ['name', 'description'];
}
