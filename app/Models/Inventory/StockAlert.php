<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class StockAlert extends Model
{
    protected $table = 'elitevw_inventory_stock_alerts';

   protected $fillable = [
    'product_id',
    'reorder_level',
    'current_stock',
    'reorder_qty',
    'status',
    'alert_date',
];

public function product()
{
    return $this->belongsTo(\App\Models\Inventory\Product::class, 'product_id');
}

public function purchaseRequest()
{
    return $this->belongsTo(PurchaseRequest::class, 'purchase_request_id');
}

}
