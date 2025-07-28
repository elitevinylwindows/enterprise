<?php

namespace App\Models\Master\Customers;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'elitevw_master_customers';

    protected $fillable = [
        'customer_number',
        'name',
        'tier',
        'loyalty_credit',
        'total_spent',
    ];
}
