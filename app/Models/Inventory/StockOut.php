<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    protected $table = 'elitevw_inventory_stock_out';

    protected $fillable = [
        'product_id', 'location_id', 'quantity', 'issued_by', 'issued_date', 'reference', 'note'
    ];
}
