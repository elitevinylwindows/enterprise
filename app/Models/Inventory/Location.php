<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'elitevw_inventory_locations';

    protected $fillable = [
        'name', 'code', 'is_active'
    ];
}
