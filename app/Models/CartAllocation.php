<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartAllocation extends Model
{
    use HasFactory;

    protected $table = 'elitevw_sr_cart_allocations';

    protected $fillable = [
        'cart_barcode',
        'item_barcode',
        'order_number',
        'width',
        'height',
        'comment',
        'customer_id',
        'customer_name',
    ];
}
