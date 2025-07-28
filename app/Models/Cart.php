<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model {
    protected $table = 'elitevw_sr_carts';
  protected $fillable = [
    'cart_barcode',
    'production_barcode',
    'description',
    'width',
    'height',
    'order_number',
    'comment',
    'customer_number',
    'customer_short_name',
];

}