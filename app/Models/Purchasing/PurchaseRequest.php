<?php

namespace App\Models\Purchasing;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    protected $table = 'elitevw_purchasing_purchase_requests';

    protected $fillable = [
        'purchase_request_id',
        'requested_by',
        'department',
        'request_date',
        'expected_date',
        'priority',
        'status',
        'notes',
    ];

    public function supplierQuotes()
    {
        return $this->hasMany(SupplierQuote::class, 'purchase_request_id');
    }
    
public function items()
{
    return $this->hasMany(PurchaseRequestItem::class);
}

}
