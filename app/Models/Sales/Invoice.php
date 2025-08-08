<?php

namespace App\Models\Sales;

use App\Models\Master\Customers\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'elitevw_sales_invoices';

    protected $fillable = [
        'invoice_number',
        'quote_id',
        'order_id',
        'customer_id',
        'invoice_date',
        'total',
        'net_price',
        'paid_amount',
        'remaining_amount',
        'status',
        'notes',
        'payment_method',
        'gateway_response',
        'serve_invoice_id',
        'due_date',
        'payment_link',
        'surcharge',
        'sub_total',
        'tax',
        'total',
        'discount',
        'shipping',
        'required_payment_type',
        'required_payment',
        'required_payment_percentage',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function quote()
    {
        return $this->belongsTo(Quote::class, 'quote_id');
    }

}
