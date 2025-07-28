<?php

namespace App\Models;
use App\Models\Driver;
use App\Models\Truck;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table = 'elitevw_sr_deliveries';

protected $casts = [
    'delivery_date' => 'date',
];

 protected $fillable = [
    'order_number',
    'address',
    'delivery_date',
    'timeframe',
    'priority',           // ✅ Must be included
    'carts',
    'customer_name',
    'short_name',
    'customer_short_name',
    'customer',
    'customer_email',
    'comment',
    'commission',
    'truck_number',
    'driver_id',
    'notes',
    'status',
    'is_delivery',        // ✅ Must be included
    'city',
    'units',
    'units_expected',
    'missing_barcodes',
    'contact_phone',
    'date_picked_up',
];



// in Delivery.php
public static function statusOptions()
{
    return [
        'pending' => 'Pending',
        'customer_notified' => 'Customer Notified',
        'in_transit' => 'In Transit',
        'cancelled' => 'Cancelled',
        'delivered' => 'Delivered / Complete',
    ];
}

public function shop()
{
    return $this->belongsTo(Shop::class, 'customer', 'customer'); 
    // adjust keys if different (foreign_key, owner_key)
}

 public function driver()
{
    return $this->belongsTo(\App\Models\Driver::class, 'driver_id');
}

public function truck()
{
    return $this->belongsTo(\App\Models\Truck::class, 'truck_number', 'id'); // if truck_number stores the ID
}


public function getCartsAttribute()
{
    return \App\Models\Cim::where('order_number', $this->order_number)
        ->pluck('cart_barcode')
        ->unique()
        ->implode('; ');
}

public function today()
{
    $today = Carbon::today()->toDateString();
    $deliveries = Delivery::whereDate('delivery_date', $today)->get();

    return view('sr.deliveries.today', compact('deliveries'));
}


    public function order()
    {
        return $this->belongsTo(Order::class, 'order_number', 'order_number');
    }
}





