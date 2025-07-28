<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class StockTransfer extends Model
{
    protected $table = 'elitevw_inventory_stock_transfers';

    protected $fillable = [
        'product_id', 'from_location_id', 'to_location_id', 'quantity', 'transferred_by', 'transferred_date', 'note'
    ];
}
