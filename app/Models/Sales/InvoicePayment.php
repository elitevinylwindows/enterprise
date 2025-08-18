<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePayment extends Model
{
    use HasFactory;

    protected $table = 'elitevw_sales_invoice_payments';

    protected $fillable = [
        'invoice_id',
        'payment_type',
        'deposit_type',
        'deposit_method',
        'last_4',
        'card_type',
        'reference_number',
        'payment_amount',
        'status',
        'payment_method',
        'gateway_response'
    ];

}
