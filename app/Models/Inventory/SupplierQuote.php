<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class SupplierQuote extends Model
{
    protected $table = 'elitevw_inventory_supplier_quotes';

    protected $fillable = [
        'quote_number', 'supplier_id', 'quote_date', 'valid_until', 'status', 'note'
    ];
}
