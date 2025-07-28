<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SrDeliveryController extends Controller
{
    public function all()
    {
        $deliveries = Delivery::all();

        foreach ($deliveries as $delivery) {
            $orderNumber = $delivery->order_number;

            $scannedCount = Cart::where('order_number', $orderNumber)->count();
            $delivery->units_check = $delivery->units - $scannedCount;
        }

        return view('sr.deliveries.all', compact('deliveries'));
    }

    public function pickupView()
    {
        $pickups = Delivery::where('is_delivery', 0)->get();
        return view('sr.deliveries.pickups', compact('pickups'));
    }

    public function today()
    {
        \Log::info('Carbon today: ' . Carbon::today()->toDateString());

$deliveries = Delivery::where('is_delivery', true)
    ->whereDate('delivery_date', Carbon::today()->toDateString())
    ->get();

foreach ($deliveries as $delivery) {
    \Log::info("Found: Order {$delivery->order_number} — Delivery Date: {$delivery->delivery_date}");
}


        return view('sr.deliveries.today', compact('deliveries'));
    }

    public function upcoming()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        $deliveries = Delivery::where('is_delivery', true)
            ->whereDate('delivery_date', '>=', $tomorrow)
            ->get();

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
            'timeframe'      => $request->timeframe,
            'contact_phone'  => $request->contact_phone,
            'customer_email' => $request->customer_email,
            'status'         => $request->status,
            'notes'         => $request->notes,

        ]);

        return redirect()->route('sr.deliveries.all')->with('success', 'Delivery updated successfully.');
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



public function refresh()
{
    $orders = Order::all();

    foreach ($orders as $order) {
        $delivery = Delivery::where('order_number', $order->order_number)->first();

        $scannedCount = Cart::where('order_number', $order->order_number)->count();
        $cartCount = Cart::where('order_number', $order->order_number)
                         ->distinct('cart_barcode')
                         ->count('cart_barcode');

        $data = [
            'customer_name' => $order->customer_name ?? '',
            'customer'      => $order->customer ?? '',
            'comment'       => $order->comment ?? '',
            'units'         => $order->units ?? 0,
            'carts'         => $cartCount,
            'units_check'   => ($order->units ?? 0) - $scannedCount,
        ];

        if ($delivery) {
            // Keep the toggle states
            $data['priority'] = $delivery->priority;
            $data['is_delivery'] = $delivery->is_delivery;

            $delivery->update($data);
        } else {
            // Set default toggle states if creating new
            $data['priority'] = 0;
            $data['is_delivery'] = 1;

            Delivery::create(array_merge(['order_number' => $order->order_number], $data));
        }
    }

    return redirect()->route('sr.deliveries.all')->with('success', 'Deliveries refreshed from Orders.');
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

            $scannedCount = Cart::where('order_number', $delivery->order_number)->count();

            $delivery->update([
                'units_check' => $expectedUnits - $scannedCount,
                'updated_at' => now(),
            ]);
        }
    }

    return redirect()->route('sr.deliveries.all')->with('success', 'Units check refreshed.');
}


    public function missingBarcodes($orderNumber)
    {
        $scannedBarcodes = Cart::where('order_number', $orderNumber)
            ->pluck('production_barcode')
            ->filter();

        // No reference source for expected barcodes; return scanned list
        return view('sr.deliveries.missing_barcodes_modal', [
            'missingBarcodes' => collect([]),
            'orderNumber'     => $orderNumber,
        ]);
    }

   public function recheckFromOrders()
{
    $existingOrderNumbers = Delivery::pluck('order_number')->toArray();
    $newOrders = Order::whereNotIn('order_number', $existingOrderNumbers)->get();

    foreach ($newOrders as $order) {
        $scannedCount = Cart::where('order_number', $order->order_number)->count();
        $cartCount = Cart::where('order_number', $order->order_number)->distinct('cart_barcode')->count('cart_barcode');

        Delivery::create([
            'order_number'   => $order->order_number,
            'customer_name'  => $order->customer_name ?? '',
            'customer'       => $order->customer ?? '',
            'comment'        => $order->comment ?? '',
            'units'          => $order->units ?? 0,
            'carts'          => $cartCount,
            'units_check'    => ($order->units ?? 0) - $scannedCount,
            'is_delivery'    => 0,
            'priority'       => 0,
            'driver_id'      => null,
        ]);
    }

    return redirect()->route('sr.deliveries.all')->with('success', 'New deliveries created from new orders.');
}

}
