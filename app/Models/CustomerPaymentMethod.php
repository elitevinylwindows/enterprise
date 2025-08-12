<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'elitevw_customer_payment_methods';

    protected $fillable = [
        'customer_id',
        'serve_customer_id',
        'serve_payment_method_id',
    ];
}
