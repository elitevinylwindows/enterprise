<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Uom extends Model
{
    protected $table = 'elitevw_inventory_uoms';

    protected $fillable = [
        'name', 'short_code', 'status'
    ];
}
