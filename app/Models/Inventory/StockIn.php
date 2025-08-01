<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    protected $table = 'elitevw_inventory_stock_in';

    protected $fillable = [
        'date', 
        'reference_no', 
        'location_id',
        'warehouse', 
        'product_id', 
        'quantity',
        'received_date',
        'supplier_id', 
        'status', 
        'note'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier()
    {
        return $this->belongsTo(\App\Models\Master\Suppliers\Supplier::class);
    }

    public function location()
{
    return $this->belongsTo(\App\Models\Inventory\Location::class, 'location_id');
}

}
