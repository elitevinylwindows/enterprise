<?php

namespace App\Models\Sales;

use App\Models\Master\Customers\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'elitevw_sales_quotes'; // use your actual table name
    protected $guarded = ['id']; // protect the id field from mass assignment
   
    public function configurations()
    {
        return $this->hasMany(\App\Models\Master\Series\SeriesType::class, 'series_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_number', 'customer_number'); 
    }

    public function items()
    {
        return $this->hasMany(QuoteItem::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'quote_id', 'id');
    }

}
