<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierPurchaseRequestQuote extends Model
{
    protected $table = 'supplier_pr_quotes';

    protected $fillable = [
        'purchase_request_id',
        'supplier_id',
        'file_path',
        'status',
    ];
}
