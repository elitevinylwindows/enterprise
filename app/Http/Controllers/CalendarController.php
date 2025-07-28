<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Cim;
use App\Models\Shop;
use Carbon\Carbon;
use App\Models\CalendarEvent;


class CalendarController extends Controller
{
    public function index()
{
    $deliveries = Delivery::whereNotNull('delivery_date')
                          ->where('is_delivery', 1)
                          ->get();

    $allEvents = $deliveries->map(function ($delivery) {
        return [
            'title' => $delivery->order_number ?? 'No Order #',
            'start' => $delivery->delivery_date,
            'type'  => 'delivery', // force type
            'status' => strtolower(trim($delivery->status ?? 'unknown')),
        ];
    });

    $totalDeliveries = $allEvents->count();
    $totalPickups = Delivery::where('is_delivery', 0)->count(); // separate count
    $pendingCount = $allEvents->where('status', 'pending')->count();
    $completedCount = $allEvents->where('status', 'completed')->count();

    return view('calendar.index', compact(
        'allEvents',
        'totalDeliveries',
        'totalPickups',
        'pendingCount',
        'completedCount'
    ));
}




public function bulkCreate(Request $request)
{
    \Log::info('📝 Bulk Calendar Form Submission', $request->all());

    $request->validate([
        'order_numbers'   => 'required|array',
        'delivery_date'   => 'required|date',
        'customer_name'   => 'required|string',
        'customer'        => 'required|string',
        'email'           => 'nullable|string',
        'contact_phone'   => 'nullable|string',
    ]);

    foreach ($request->order_numbers as $orderNumber) {
        $order = Order::where('order_number', $orderNumber)->first();
        $delivery = Delivery::where('order_number', $orderNumber)->first();

        $units = $order->units ?? 0;
        $carts = $order ? Cim::where('order_number', $order->order_number)->distinct('cart_barcode')->count('cart_barcode') : 0;
        $scanned = $order ? Cim::where('order_number', $order->order_number)->count() : 0;

        $baseData = [
            'delivery_date'  => $request->delivery_date,
            'timeframe'      => $request->timeframe,
            'comment'        => $request->comment,
            'email'          => $request->email,
            'contact_phone'  => $request->contact_phone,
            'customer_name'  => $request->customer_name ?? ($order->short_name ?? ''),
            'customer'       => $request->customer ?? ($order->customer ?? ''),
            'city'           => $request->city ?? ($order->city ?? ''),
            'address'        => $request->address ?? ($order->address ?? ''),
            'zip'            => $request->zip ?? ($order->zip ?? ''),
            'units'          => $units,
            'carts'          => $carts,
            'units_check'    => $units - $scanned,
            'is_delivery'    => 1,
            'priority'       => 0,
            'status'         => 'pending',
        ];

        if ($delivery) {
            $delivery->update($baseData);
        } else {
            Delivery::create(array_merge(['order_number' => $orderNumber], $baseData));
        }
    }

    return redirect()->route('calendar.index')->with('success', 'Bulk deliveries created.');
}



public function bulkCreateForm(Request $request)
{
    $deliveryIds = json_decode($request->query('ids', '[]'), true);

    if (!is_array($deliveryIds)) {
        return response('Invalid format for IDs', 400);
    }

    // Step 1: Get the deliveries
    $deliveries = \App\Models\Delivery::whereIn('id', $deliveryIds)->get();

    // Step 2: Get unique order numbers from the deliveries
    $orderNumbers = $deliveries->pluck('order_number')->unique();

    // Step 3: Now fetch the matching orders
    $orders = \App\Models\Order::whereIn('order_number', $orderNumbers)->get();

    $firstOrder = $orders->first();
    $shop = \App\Models\Shop::where('customer', $firstOrder->customer ?? null)->first();

    return view('calendar.bulkcreate', compact('orders', 'shop'));
}






public function getShopByCustomer(Request $request)
{
    $shop = Shop::where('customer', $request->customer)->first();

    if (!$shop) {
        return response()->json(['error' => 'Shop not found'], 404);
    }

    return response()->json([
        'customer_name' => $shop->customer_name,
        'email' => $shop->email,
        'contact_phone' => $shop->contact_phone,
        'address'       => $shop->address,
        'city'          => $shop->city,
        'zip'           => $shop->zip,
    ]);
}


public function updateDate(Request $request)
{
    $request->validate([
        'order_number'   => 'required|string',
        'delivery_date'  => 'required|date',
    ]);

    $delivery = \App\Models\Delivery::where('order_number', $request->order_number)->first();

    if (!$delivery) {
        return response()->json(['error' => 'Delivery not found'], 404);
    }

    $delivery->update([
        'delivery_date' => $request->delivery_date
    ]);

    return response()->json(['success' => true]);
}

    public function create()
    {
        return view('calendar.modals.create');
    }

    public function getOrderDetails($order_number)
    {
        $order = Order::where('order_number', $order_number)->first();

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        return response()->json([
            'customer_name' => $order->short_name,
            'customer'      => $order->customer,
            'city'          => $order->city,
            'units'         => $order->units,
            'comment'       => $order->comment,
        ]);
    }


public function store(Request $request)
{
    \Log::info('📝 Calendar Form Submission', $request->all());

    $request->validate([
        'order_number'   => 'required|string',
        'customer_name'  => 'required|string',
        'customer'       => 'required|string',
        'email'       => 'required|string',
        'contact_phone'       => 'required|string',
        'delivery_date'  => 'required|date',
        'timeframe'      => 'nullable|string',
        'comment'        => 'nullable|string',
        'address'        => 'nullable|string',
        'city'           => 'nullable|string',
        'zip'            => 'nullable|string',
    ]);

    $order = Order::where('order_number', $request->order_number)->first();
    $delivery = Delivery::where('order_number', $request->order_number)->first();

    $units = $order->units ?? 0;
    $carts = $order ? Cim::where('order_number', $order->order_number)->distinct('cart_barcode')->count('cart_barcode') : 0;
    $scanned = $order ? Cim::where('order_number', $order->order_number)->count() : 0;

    $baseData = [
        'delivery_date'  => $request->delivery_date,
        'timeframe'      => $request->timeframe,
        'comment'        => $request->comment,
         'email'        => $request->email,
          'contact_phone'        => $request->contact_phone,
'customer_name' => $request->filled('customer_name') ? $request->customer_name : ($order->short_name ?? ''),
'customer' => $request->filled('customer') ? $request->customer : ($order->customer ?? ''),
        'city'           => $request->city ?? ($order->city ?? ''),
        'address'        => $request->address ?? ($order->address ?? ''),
        'zip'            => $request->zip ?? ($order->zip ?? ''),
        'units'          => $units,
        'carts'          => $carts,
        'units_check'    => $units - $scanned,
        'is_delivery'    => 1,
        'priority'       => 0,
        'status'         => 'pending',
    ];

    if ($delivery) {
        $delivery->update($baseData);
    } else {
        Delivery::create(array_merge(['order_number' => $request->order_number], $baseData));
    }

    return redirect()->route('calendar.index')->with('success', 'Event created successfully.');
}




    public function deliveriesByDate($date)
    {
        $parsedDate = Carbon::parse($date)->toDateString();
        $deliveries = Delivery::whereDate('delivery_date', $parsedDate)->get();

        return view('calendar.deliveries_by_date', compact('deliveries', 'date'));
    }


    public function calendarView()
    {
        $deliveries = Delivery::whereNotNull('delivery_date')->where('is_delivery', 1)->get();

        $events = [];
        foreach ($deliveries as $delivery) {
            $events[] = [
                'title' => 'Order #' . $delivery->order_number,
                'start' => $delivery->delivery_date,
            ];
        }

        $totalDeliveries = Delivery::where('is_delivery', 1)->count();
        $totalPickups = Delivery::where('is_delivery', 0)->count();
        $pendingCount = Delivery::where('status', 'pending')->count();
        $completedCount = Delivery::where('status', 'complete')->count();

        return view('calendar.index', compact(
            'events',
            'totalDeliveries',
            'totalPickups',
            'pendingCount',
            'completedCount'
        ));
    }
}
