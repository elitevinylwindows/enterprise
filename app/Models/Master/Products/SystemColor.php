<?php

namespace App\Models\Master\Products;

use Illuminate\Database\Eloquent\Model;

class SystemColor extends Model
{
    protected $table = 'elitevw_master_products_system_color';

    protected $fillable = ['name', 'description'];
}
