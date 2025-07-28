<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class StockAdjustment extends Model
{
    protected $table = 'elitevw_inventory_stock_adjustments';

    protected $fillable = [
        'product_id', 'location_id', 'adjustment_type', 'quantity', 'adjusted_by', 'adjusted_date', 'note'
    ];
}
