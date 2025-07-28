<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cim extends Model
{
    protected $table = 'elitevw_sr_cims';

protected $fillable = [
    'order_number', 'cart_barcode', 'production_barcode', 'customer', 'customer_name', 'customer_short_name', 'description', 'comment', 'width', 'height'
];


}








