<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    protected $table = 'elitevw_inventory_barcodes';

    protected $fillable = [
        'product_id', 'code', 'type', 'is_active'
    ];
}
