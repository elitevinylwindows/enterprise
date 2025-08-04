<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class SupplierQuote extends Model
{
    protected $table = 'elitevw_inventory_supplier_quotes';

    protected $fillable = [
        'quote_number',
        'supplier_id',
        'quote_date',
        'valid_until',
        'status',
        'purchase_request_id',
        'file_path',
        'total_amount',
    ];

    public function supplier()
    {
        return $this->belongsTo(\App\Models\Master\Suppliers\Supplier::class);
    }

    public function purchaseRequest()
    {
        return $this->belongsTo(\App\Models\Purchasing\PurchaseRequest::class, 'purchase_request_id');
    }
}
