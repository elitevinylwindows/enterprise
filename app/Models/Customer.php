<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'elitevw_sr_customers';

    protected $fillable = [
        'customer_number',
        'name',
        'tier',
        'loyalty_credit',
        'total_spent',
    ];
}
