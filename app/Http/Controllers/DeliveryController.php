<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Driver;
use App\Models\Truck;
use App\Models\Shop;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
   
   
 public function index()
{
    $deliveries = Delivery::with(['driver', 'truck']) // eager load
        ->where('is_delivery', 1)
        ->orderBy('truck_number')
        ->orderBy('sort_order')
        ->get();

    $drivers = Driver::all();
    $trucks = Truck::all();

    return view('deliveries.index', compact('deliveries', 'drivers', 'trucks'));
}


   public function edit(Delivery $delivery)
{
    $drivers = \App\Models\Driver::pluck('name', 'id'); // ✅ Only get name/id pair
    $trucks = \App\Models\Truck::pluck('truck_number', 'id'); // ✅ Only get truck_number/id pair

    return view('deliveries.modals.edit', compact('delivery', 'drivers', 'trucks'));
}


    public function update(Request $request, Delivery $delivery)
    {
        $delivery->update([
            'status'     => $request->status,
            'driver_id'  => $request->driver_id,
            'notes'      => $request->notes,
            'truck_number'   => $request->truck_number,
        ]);

        return redirect()->back()->with('success', 'Delivery updated.');
    }
    
    
     //Today & Upcoming
public function today()
{
    $today = \Carbon\Carbon::today()->toDateString();

    $deliveries = Delivery::where('is_delivery', true)
        ->whereDate('delivery_date', $today)
        ->orderBy('truck_number')
        ->orderBy('sort_order')
        ->get();

    return view('deliveries.today', compact('deliveries'));
}

public function upcoming()
{
    $tomorrow = \Carbon\Carbon::tomorrow()->toDateString();

    $deliveries = Delivery::where('is_delivery', true)
        ->whereDate('delivery_date', '>=', $tomorrow)
        ->orderBy('truck_number')
        ->orderBy('sort_order')
        ->get();

    return view('deliveries.upcoming', compact('deliveries'));
}


public function getShopContact(Request $request)
{
    $shop = Shop::where('customer', $request->customer)->first();

    if (!$shop) {
        return response()->json(['error' => 'Shop not found'], 404);
    }

    return response()->json([
        'email' => $shop->email,
        'contact_phone' => $shop->contact_phone,
    ]);
}
public function shop()
{
    return $this->hasOne(Shop::class, 'customer', 'customer');
}

public function show(Delivery $delivery)
{
    return view('deliveries.modals.show', compact('delivery'));
}

}
