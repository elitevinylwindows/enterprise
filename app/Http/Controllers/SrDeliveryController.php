<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cim;
use App\Models\Shop;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Models\RingCentral;


class SrDeliveryController extends Controller
{
  public function all()
{
    $deliveries = Delivery::with(['shop' => function ($q) {
        $q->select('customer', 'email', 'contact_phone');
    }])->get();

    foreach ($deliveries as $delivery) {
        $orderNumber = $delivery->order_number;

        $scannedCount = Cim::where('order_number', $orderNumber)->count();
        $delivery->units_check = $delivery->units - $scannedCount;
    }

    return view('sr.deliveries.all', compact('deliveries'));
}



public function store(Request $request)
{
    $request->validate([
        'order_number'   => 'required|string',
        'address'   => 'required|string',
        'city'   => 'required|string',
        'delivery_date'  => 'required|date',
        'timeframe'      => 'nullable|string',
        'comment'        => 'nullable|string',
        'commission'        => 'nullable|string',
    ]);

    $order = \App\Models\Order::where('order_number', $request->order_number)->first();

    $data = [
        'delivery_date'  => $request->delivery_date,
        'timeframe'      => $request->timeframe,
        'comment'        => $request->comment,
        'commission'        => $request->commission,
        'is_delivery'    => 1,// everytime a delivery is manually created like from the calendar its saved as delivery if 1 ** DO NOT CHANGE**
        'priority'       => 0,
'customer_name' => $request->filled('customer_name') ? $request->customer_name : ($order->short_name ?? ''),
'customer' => $request->filled('customer') ? $request->customer : ($order->customer ?? ''),

        'city'     => $request->city,
'address'  => $request->address,
'zip'      => $request->zip, // add this if applicable

        'contact_phone'  => $order->contact_phone ?? '',
        'status'         => 'pending',
        'units'          => $order->units ?? 0,
        'carts'          => 0,
        'units_check'    => $order ? $order->units - 0 : 0,
    ];

    $delivery = \App\Models\Delivery::where('order_number', $request->order_number)->first();

    if ($delivery) {
        $delivery->update($data);
    } else {
        Delivery::create(array_merge(['order_number' => $request->order_number], $data));
    }

    return redirect()->route('calendar.index')->with('success', 'Event created successfully.');
}

public function callDeliveryContact($deliveryId)
{
    $delivery = Delivery::findOrFail($deliveryId);
    $user = Auth::user();

    if (!$user->rc_access_token || !$delivery->contact_phone) {
        return back()->with('error', 'Missing RingCentral token or delivery contact.');
    }

    $url = env('RINGCENTRAL_SERVER_URL') . '/restapi/v1.0/account/~/extension/~/ring-out';

    try {
        $response = Http::withHeaders($this->tokenHeaders($user))->post($url, [
            'from' => ['phoneNumber' => $user->rc_email],  // or hardcoded number if required
            'to' => ['phoneNumber' => $delivery->contact_phone],
            'playPrompt' => false,
        ]);

        if ($response->successful()) {
            return back()->with('success', 'Call initiated to ' . $delivery->contact_phone);
        }

        return back()->with('error', 'Call failed: ' . $response->body());

    } catch (\Exception $e) {
        return back()->with('error', 'Exception during call: ' . $e->getMessage());
    }
}



    public function pickupView()
    {
        $pickups = Delivery::where('is_delivery', 0)->get();
        return view('sr.deliveries.pickups', compact('pickups'));
    }

 //Today & Upcoming
public function today()
{
    $today = \Carbon\Carbon::today()->toDateString();

    $deliveries = \App\Models\Delivery::where('is_delivery', true)
        ->whereDate('delivery_date', $today)
        ->get();

    foreach ($deliveries as $delivery) {
        $scannedCount = \App\Models\Cim::where('order_number', $delivery->order_number)->count();
        $delivery->units_check = $delivery->units - $scannedCount;
    }

    return view('sr.deliveries.today', compact('deliveries'));
}


public function upcoming()
{
    $tomorrow = \Carbon\Carbon::tomorrow()->toDateString();

    $deliveries = \App\Models\Delivery::where('is_delivery', true)
        ->whereDate('delivery_date', '>=', $tomorrow)
        ->get();

    foreach ($deliveries as $delivery) {
        $scannedCount = \App\Models\Cim::where('order_number', $delivery->order_number)->count();
        $delivery->units_check = $delivery->units - $scannedCount;
    }

    return view('sr.deliveries.upcoming', compact('deliveries'));
}



    public function edit($id)
    {
        $delivery = Delivery::findOrFail($id);
        return view('sr.deliveries.modals.edit', compact('delivery'));
    }

    public function update(Request $request, $id)
    {
        $delivery = Delivery::findOrFail($id);

        $delivery->update([
            'address'        => $request->address,
            'city'           => $request->city,
            'delivery_date'      => $request->delivery_date,
            'timeframe'      => $request->timeframe,
            'contact_phone'  => $request->contact_phone,
            'customer_email' => $request->customer_email,
            'status'         => $request->status,
            'notes'         => $request->notes,

        ]);

        return redirect()->route('sr.deliveries.all')->with('success', 'Delivery updated successfully.');
    }



public function getShopByCustomer(Request $request)
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

public function toggleFieldButton(Request $request, $id)
{
    $field = $request->input('field');
    $value = $request->input('value');

    \Log::info('Button Toggle', ['id' => $id, 'field' => $field, 'value' => $value]);

    $delivery = Delivery::findOrFail($id);

    if (!in_array($field, ['priority', 'is_delivery'])) {
        return back()->with('error', 'Invalid toggle field.');
    }

    $delivery->{$field} = $value;
    $delivery->save();

    return back()->with('success', ucfirst($field) . ' updated.');
}


public function show($id)
{
    $delivery = Delivery::findOrFail($id);
    return view('sr.deliveries.show', compact('delivery'));
}





public function toggleDelivery(Request $request, $id)
{
    \Log::info('ToggleDelivery triggered', ['id' => $id, 'request' => $request->all()]);

    $delivery = Delivery::findOrFail($id);
    $isDelivery = $request->input('is_delivery');

    if ((int)$isDelivery === 1) {
        // Send back modal trigger
        return response()->json([
            'open_modal' => true,
            'order_number' => $delivery->order_number,
        ]);
    }

    // Clear delivery date and switch to pickup
    $delivery->update([
        'is_delivery' => 0,
        'delivery_date' => null,
    ]);

    return response()->json([
        'open_modal' => false,
        'message' => 'Marked as pickup.',
    ]);
}




public function refresh()
{
    $orders = Order::all();

    foreach ($orders as $order) {
        $delivery = Delivery::where('order_number', $order->order_number)->first();
        $this->updateDeliveryCartsField($order->order_number);

        $scannedCount = Cim::where('order_number', $order->order_number)->count();
        $cartCount = Cim::where('order_number', $order->order_number)
                         ->distinct('cart_barcode')
                         ->count('cart_barcode');

        $data = [
            'customer_name' => $order->short_name ?? '',
            'customer'      => $order->customer ?? '',
            'comment'      => $order->comment ?? '',
            'commission'      => $order->commission ?? '',
            'units'         => $order->units ?? 0,
            'carts'         => $cartCount,
            'units_check'   => ($order->units ?? 0) - $scannedCount,
        ];

        // Preserve existing delivery values
        if ($delivery) {
            $data['city'] = $delivery->city ?? $order->city ?? '';
            $data['address'] = $delivery->address ?? $order->address ?? '';
            $data['delivery_date'] = $delivery->delivery_date;
           
            $data['priority'] = $delivery->priority;
            $data['is_delivery'] = $delivery->is_delivery;

            $delivery->update($data);
        } else {
            $data['city'] = $order->city ?? '';
            $data['address'] = $order->address ?? '';
            $data['delivery_date'] = null;
            $data['comment'] = $order->comment ?? '';
            $data['commission'] = $order->commission ?? '';
            $data['priority'] = 0;
            $data['is_delivery'] = 0;

            Delivery::create(array_merge(['order_number' => $order->order_number], $data));
        }
    }

    return redirect()->route('sr.deliveries.all')->with('success', 'Deliveries refreshed from Orders.');
}


public function updateDeliveryCartsField($orderNumber)
{
    $cartBarcodes = \App\Models\Cim::where('order_number', $orderNumber)
        ->whereNotNull('cart_barcode')
        ->pluck('cart_barcode')
        ->unique()
        ->toArray();

    $cartList = implode('; ', $cartBarcodes);

    \App\Models\Delivery::where('order_number', $orderNumber)->update([
        'carts' => $cartList,
    ]);
}


     public function refreshUnitCheck()
{
    $deliveries = Delivery::all();

    foreach ($deliveries as $delivery) {
        $order = Order::where('order_number', $delivery->order_number)->first();

        if ($order) {
            // Force raw DB value
            $expectedUnits = DB::table('elitevw_sr_orders')
                ->where('order_number', $delivery->order_number)
                ->value('units');

            $scannedCount = Cim::where('order_number', $delivery->order_number)->count();

            $delivery->update([
                'units_check' => $expectedUnits - $scannedCount,
                'updated_at' => now(),
            ]);
        }
    }

    return redirect()->route('sr.deliveries.all')->with('success', 'Units check refreshed.');
}


 //Import new orders just added to ordermenu
  public function recheckFromOrders()
{
    $existingOrderNumbers = Delivery::pluck('order_number')->toArray();

    $newOrders = Order::whereNotIn('order_number', $existingOrderNumbers)->get();

    foreach ($newOrders as $order) {
        $scannedCount = Cim::where('order_number', $order->order_number)->count();
        $cartCount = Cim::where('order_number', $order->order_number)
                         ->whereNotNull('cart_barcode')
                         ->distinct()
                         ->count('cart_barcode');

        Delivery::create([
            'order_number'   => $order->order_number,
            'customer_name'  => $order->short_name ?? '',
            'city'  => $order->city ?? '',
            'customer'       => $order->customer ?? '',
            'comment'        => $order->comment ?? '',
            'commission'        => $order->commission ?? '',
            'units'          => $order->units ?? 0,
            'carts'          => $cartCount,
            'units_check'    => ($order->units ?? 0) - $scannedCount,
            'is_delivery'    => 0,
            'priority'       => 0,
            'driver_id'      => null,
            'truck_id'      => null,
            'date_picked_up' => null,
        ]);
    }

    return redirect()->route('sr.deliveries.all')->with('success', 'New deliveries created from new orders.');
}

public function destroy($id)
{
    $delivery = Delivery::findOrFail($id);
    $delivery->delete();

    return back()->with('success', 'Delivery deleted successfully.');
}


public function fixEmptyStatuses()
{
    \App\Models\Delivery::whereNull('status')
        ->orWhere('status', '')
        ->update(['status' => 'pending']);

    return redirect()->back()->with('success', 'All empty statuses updated to "pending".');
}

}
