<?php

namespace App\Models\Purchasing;

use Illuminate\Database\Eloquent\Model;
use App\Models\Inventory\Product;


class PurchaseRequestItem extends Model
{
    protected $table = 'elitevw_purchasing_purchase_request_items';

    protected $fillable = [
        'purchase_request_id', 'product_id', 'description', 'qty', 'price', 'total'
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function request()
    {
        return $this->belongsTo(PurchaseRequest::class, 'purchase_request_id');
    }
}
