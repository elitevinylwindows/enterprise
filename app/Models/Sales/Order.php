<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'elitevw_sales_orders';

    protected $fillable = [
        'order_number',
        'quote_id',
        'customer_id',
        'invoice_date',
        'net_price',
        'status',
        'notes',
        'paid_amount',
        'remaining_amount',
        'approved_by',
        'entered_by',
        'due_date',
        'work_order_number',
    ];

    // Relationships

    public function customer()
    {
        return $this->belongsTo(\App\Models\Master\Customers\Customer::class);
    }

    public function quote()
    {
        return $this->belongsTo(\App\Models\Sales\Quote::class);
    }

    public function invoice()
    {
        return $this->hasOne(\App\Models\Sales\Invoice::class);
    }

    public function items()
    {
        return $this->hasMany(\App\Models\Sales\OrderItem::class);
    }
}
