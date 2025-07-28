<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    protected $table = 'elitevw_inventory_stock_in';

    protected $fillable = [
        'product_id', 'location_id', 'quantity', 'received_by', 'received_date', 'reference', 'note'
    ];
}
