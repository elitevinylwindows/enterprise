<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'elitevw_sales_invoices';

    protected $fillable = [
        'customer_id',
        'invoice_date',
        'net_price',
        'status',
        'notes',
        'paid_amount',
        'remaining_amount',
    ];

    public function customer()
{
    return $this->belongsTo(\App\Models\Master\Customers\Customer::class, 'customer_id');
}

}
