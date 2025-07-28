<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = 'elitevw_inventory_purchase_orders';

    protected $fillable = [
        'order_number', 'supplier_id', 'order_date', 'delivery_date', 'status', 'note'
    ];
}
