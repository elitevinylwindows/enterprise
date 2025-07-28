<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'elitevw_inventory_stock_logs';

    protected $fillable = [
        'product_id', 'location_id', 'change_type', 'quantity', 'reference', 'note', 'created_by'
    ];
}
