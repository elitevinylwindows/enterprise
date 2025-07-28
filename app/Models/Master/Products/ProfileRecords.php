<?php

namespace App\Models\Master\Products;

use Illuminate\Database\Eloquent\Model;

class ProfileRecords extends Model
{
    protected $table = 'elitevw_master_products_profile_records';

    protected $fillable = ['profile_record', 'name', 'description'];
}
