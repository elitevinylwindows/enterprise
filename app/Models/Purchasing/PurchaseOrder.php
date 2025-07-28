<?php

namespace App\Models\Purchasing;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = 'elitevw_purchasing_purchase_orders';

    protected $fillable = [
        'supplier_quote_id',
        'order_number',
        'order_date',
        'expected_delivery',
        'tracking_number',
        'shipping_method',
        'status',
        'notes',
    ];

    public function supplierQuote()
    {
        return $this->belongsTo(SupplierQuote::class, 'supplier_quote_id');
    }
}
