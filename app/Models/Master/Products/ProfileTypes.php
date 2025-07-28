<?php

namespace App\Models\Master\Products;

use Illuminate\Database\Eloquent\Model;

class ProfileTypes extends Model
{
    protected $table = 'elitevw_master_products_profile_types';

    protected $fillable = ['name', 'description'];
}
