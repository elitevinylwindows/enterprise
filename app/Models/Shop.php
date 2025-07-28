<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $table = 'elitevw_sr_shops'; // ✅ explicitly define table name

    protected $fillable = [
        'customer',
     'customer_name',
     'email',
     'contact_phone',
        'address',
        'city',
        'zip',
    ];
}
