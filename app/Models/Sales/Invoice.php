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

    protected $dates = ['deleted_at'];
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
        'deposit_amount',
        'deposit_type' ,
        'deposit_method'
    ];

    public function getPaymentTypeAttribute()
    {
        if ($this->payments->count() === 0) {
            return $this->deposit_method ? $this->deposit_method : 'none';
        }
        if ($this->payments->count() === 1) {
            return $this->payments->first()->deposit_method;
        }
        $paymentTypes = $this->payments->pluck('deposit_method')->unique();
        if ($paymentTypes->count() === 1) {
            return $paymentTypes->first();
        }
        return 'mixed';
    }

    public function getRemainingAmountAttribute()
    {
        $paidAmount = $this->payments->sum(function ($payment) {
            if (is_array($payment->payment_amount)) {
            return array_sum($payment->payment_amount);
            }
            return $payment->payment_amount;
        });
        return $this->total - $paidAmount;
    }

    public function getPaidAmountAttribute()
    {
        $paidAmount = $this->payments->sum(function ($payment) {
            if (is_array($payment->payment_amount)) {
                return array_sum($payment->payment_amount);
            }
            return $payment->payment_amount;
        });
        return $paidAmount;
    }

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

    public function payments()
    {
        return $this->hasMany(InvoicePayment::class, 'invoice_id');
    }

}
