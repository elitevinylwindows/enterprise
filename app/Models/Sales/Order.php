<?php

namespace App\Models\Sales;

use App\Models\Manufacturing\JobPool;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
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
        'expected_delivery_date',
        'surcharge',
        'sub_total',
        'tax',
        'total',
        'discount',
        'shipping',
        'is_rush',
        'rushed_at',
        'editable_until'

    ];

    // Relationships

     public function user()
    {
        return $this->belongsTo(User::class, 'entered_by', 'id');
    }


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
        return $this->hasMany(OrderItem::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

    public function job_pool()
    {
        return $this->hasOne(JobPool::class, 'order_id', 'id');
    }

}


