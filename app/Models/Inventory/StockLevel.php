<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class StockLevel extends Model
{
    
    protected $table = 'elitevw_inventory_stock_levels';

    protected $fillable = [
        'product_id', 'location_id', 'stock_on_hand', 'stock_reserved', 'stock_available', 'minimum_level', 'maximum_level', 'reorder_level'
    ];

public function product()
{
    return $this->belongsTo(\App\Models\Inventory\Product::class);
}
public function location()
{
    return $this->belongsTo(\App\Models\Inventory\Location::class);
}
}
