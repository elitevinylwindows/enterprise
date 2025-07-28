<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'sku',
        'item_name',
        'quantity',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
