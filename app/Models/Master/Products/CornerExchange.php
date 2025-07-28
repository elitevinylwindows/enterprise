<?php

namespace App\Models\Master\Products;

use Illuminate\Database\Eloquent\Model;

class CornerExchange extends Model
{
    protected $table = 'elitevw_master_products_corner_exchange';

    protected $fillable = ['corner_exchnage_type', 'name', 'description'];
}
