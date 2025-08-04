<?php

namespace App\Models\Purchasing;

use Illuminate\Database\Eloquent\Model;

class SupplierQuote extends Model
{
    protected $table = 'elitevw_purchasing_supplier_quotes';

    protected $fillable = [
        'purchase_request_id',
        'supplier_id',
        'quote_date',
        'quote_reference',
        'total_amount',
        'secure_token',
        'status',
        'attachment_path',
        'notes',
    ];

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class, 'purchase_request_id');
    }

    public function supplier()
    {
return $this->belongsTo(\App\Models\Master\Suppliers\Supplier::class, 'supplier_id');
    }

    public function purchaseOrder()
    {
        return $this->hasOne(PurchaseOrder::class, 'supplier_quote_id');
    }
}
