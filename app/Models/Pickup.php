<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pickup extends Model
{
    use HasFactory;

    protected $table = 'elitevw_sr_pickups';

    protected $fillable = [
        'order_number',
    'address',
    'customer_name',
    'customer',
        'status',
        'date_picked_up',
    'units',
        'carts',
    ];
}
