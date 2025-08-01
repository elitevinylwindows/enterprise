<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Models\Inventory\Product;
use App\Models\Inventory\StockLevel;

class StockAdjustment extends Model
{
    protected $table = 'elitevw_inventory_stock_adjustments';

    protected $fillable = [
        'product_id',
        'location_id',
        'quantity',
        'reason',
        'status',
        'reference_no',
        'date'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
