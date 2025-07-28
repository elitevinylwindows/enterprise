<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    protected $table = 'elitevw_inventory_purchase_requests';

    protected $fillable = [
        'request_number', 'requested_by', 'request_date', 'status', 'note'
    ];
}
