<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use App\Models\Delivery;
use App\Models\Driver;
use Illuminate\Http\Request;
use App\Services\RouteBuilder;
use Illuminate\Support\Facades\Auth;

class RouteController extends Controller
{
    public function index()
    {
        $warehouseAddress = '4231 Liberty Blvd, South Gate, CA';

        $deliveries = Delivery::where('is_delivery', 1)
            ->whereNotNull('truck_number')
            ->whereNotNull('address')
            ->orderBy('delivery_date')
            ->get();

        $routes = [];

        foreach ($deliveries->groupBy('truck_number') as $truckId => $groupedDeliveries) {
            $truck = $groupedDeliveries->first()->truck;
            $driver = $groupedDeliveries->first()->driver;

            $routes[] = [
                'truck_id' => $truck->truck_number ?? $truckId,
                'truck_name' => $truck->truck_number ?? 'Unknown Truck',
                'driver' => $driver->name ?? 'Unknown Driver',
                'stops' => $groupedDeliveries->map(function ($d) {
                    return [
                        'id' => $d->id,
                        'address' => $d->address,
                        'city' => $d->city,
                        'lat' => $d->lat,
                        'lng' => $d->lng,
                        'customer' => $d->customer_name,
                        'contact' => $d->contact_phone,
                        'order' => $d->order_number,
                        'status' => $d->status
                    ];
                })
            ];
        }

        $mapStyle = json_encode([
   [
        "featureType"=> "water",
        "elementType"=> "geometry",
        "stylers"=> [
            [
                "color"=> "#e9e9e9"
            ],
            [
                "lightness"=> 17
            ]
        ]
    ],
    [
        "featureType"=> "landscape",
        "elementType"=> "geometry",
        "stylers"=> [
            [
                "color"=> "#f5f5f5"
            ],
            [
                "lightness"=> 20
            ]
        ]
    ],
    [
        "featureType"=> "road.highway",
        "elementType"=> "geometry.fill",
        "stylers"=> [
            [
                "color"=> "#ffffff"
            ],
            [
                "lightness"=> 17
            ]
        ]
    ],
    [
        "featureType"=> "road.highway",
        "elementType"=> "geometry.stroke",
        "stylers"=> [
            [
                "color"=> "#ffffff"
            ],
            [
                "lightness"=> 29
            ],
            [
                "weight"=> 0.2
            ]
        ]
    ],
    [
        "featureType"=> "road.arterial",
        "elementType"=> "geometry",
        "stylers"=> [
            [
                "color"=> "#ffffff"
            ],
            [
                "lightness"=> 18
            ]
        ]
    ],
    [
        "featureType"=> "road.local",
        "elementType"=> "geometry",
        "stylers"=> [
            [
                "color"=> "#ffffff"
            ],
            [
                "lightness"=> 16
            ]
        ]
    ],
    [
        "featureType"=> "poi",
        "elementType"=> "geometry",
        "stylers"=> [
            [
                "color"=> "#f5f5f5"
            ],
            [
                "lightness"=> 21
            ]
        ]
    ],
    [
        "featureType"=> "poi.park",
        "elementType"=> "geometry",
        "stylers"=> [
            [
                "color"=> "#dedede"
            ],
            [
                "lightness"=> 21
            ]
        ]
    ],
    [
        "elementType"=> "labels.text.stroke",
        "stylers"=> [
            [
                "visibility"=> "on"
            ],
            [
                "color"=> "#ffffff"
            ],
            [
                "lightness"=> 16
            ]
        ]
    ],
    [
        "elementType"=> "labels.text.fill",
        "stylers"=> [
            [
                "saturation"=> 36
            ],
            [
                "color"=> "#333333"
            ],
            [
                "lightness"=> 40
            ]
        ]
    ],
    [
        "elementType"=> "labels.icon",
        "stylers"=> [
            [
                "visibility"=> "off"
            ]
        ]
    ],
    [
        "featureType"=> "transit",
        "elementType"=> "geometry",
        "stylers"=> [
            [
                "color"=> "#f2f2f2"
            ],
            [
                "lightness"=> 19
            ]
        ]
    ],
    [
        "featureType"=> "administrative",
        "elementType"=> "geometry.fill",
        "stylers"=> [
            [
                "color"=> "#fefefe"
            ],
            [
                "lightness"=> 20
            ]
        ]
    ],
    [
        "featureType"=> "administrative",
        "elementType"=> "geometry.stroke",
        "stylers"=> [
            [
                "color"=> "#fefefe"
            ],
            [
                "lightness"=> 17
            ],
            [
                "weight"=> 1.2
            ]
        ]
    ]
]);
     

        return view('routes.index', compact('routes', 'warehouseAddress', 'mapStyle'));
    }

public function autoRouteView()
{
    $warehouseAddress = '4231 Liberty Blvd, South Gate, CA';
    $user = Auth::user();

    $deliveries = Delivery::with('shop', 'driver')
        ->whereNotNull('truck_number')
        ->whereNotNull('address')
        ->orderBy('sort_order')
        ->get();

    $routes = [];
    $groupedRoutes = [];

    foreach ($deliveries->groupBy('truck_number') as $truckId => $truckDeliveries) {
        $driver = $truckDeliveries->first()->driver;

        $groupedStops = $truckDeliveries->groupBy(function ($d) {
            return $d->address . '|' . $d->city;
        });

        $stops = [];
        $prefix = is_numeric($truckId) ? chr(65 + intval($truckId) - 1) : strtoupper(substr($truckId, 0, 1));
        $i = 1;

        foreach ($groupedStops as $key => $group) {
            [$address, $city] = explode('|', $key);
            $ids = $group->pluck('id')->toArray();
            $orderNumbers = $group->pluck('order_number')->toArray();
            $customer = $group->pluck('customer_name')->first();
            $contact = optional($group->first()->shop)->contact_phone;
            $status = $group->pluck('status')->unique()->implode(', ');

            $stops[] = [
                'ids' => $ids,
                'address' => $address,
                'city' => $city,
                'lat' => $group->first()->lat,
                'lng' => $group->first()->lng,
                'customer' => $customer,
                'order_numbers' => $orderNumbers,
                'contact' => $contact,
                'status' => $status,
                'label' => $prefix . $i,
                'title' => 'Stop: ' . $customer
            ];

            $i++;
        }

        $route = [
            'truck_number' => $truckId,
            'driver_id' => $driver->id ?? null,
            'driver' => $driver->name ?? 'Unknown Driver',
            'stops' => $stops
        ];

        $routes[] = $route;

        // Set groupedRoutes under the delivery_date of the first delivery
        $deliveryDate = optional($truckDeliveries->first()->delivery_date)
            ? \Carbon\Carbon::parse($truckDeliveries->first()->delivery_date)->toDateString()
            : now()->toDateString();

        $groupedRoutes[$deliveryDate][] = $route;
    }

    // Filter only current driver's routes if role = driver
    if ($user->hasRole('driver') && $user->driver_id) {
        $routes = array_filter($routes, function ($route) use ($user) {
            return $route['driver_id'] == $user->driver_id;
        });

        // Rebuild groupedRoutes for drivers
        $groupedRoutes = [];
        foreach ($routes as $r) {
            $groupedRoutes[$deliveryDate][] = $r;
        }
    }

    return view('routes.auto', compact('routes', 'groupedRoutes', 'warehouseAddress'));
}

public function driverRoutes()
{
    $user = auth()->user();

    if (!$user->can('manage my route')) {
        abort(403, 'Access denied');
    }

    if (!$user->driver_id) {
        abort(403, 'No driver ID linked to this user.');
    }

    $warehouseAddress = '4231 Liberty Blvd, South Gate, CA';

   $deliveries = Delivery::with('driver', 'shop')
    ->where('driver_id', $user->driver_id)
    ->whereNotNull('truck_number')
    ->whereNotNull('address')
    ->orderBy('sort_order') // ✅ FIX HERE
    ->get();


    foreach ($deliveries->groupBy('truck_number') as $truckId => $truckDeliveries) {
        $driver = $truckDeliveries->first()->driver;

        $groupedStops = $truckDeliveries->groupBy(function ($item) {
            return $item->address . '|' . $item->city;
        });

        $stops = [];
        $prefix = is_numeric($truckId) ? chr(65 + intval($truckId) - 1) : strtoupper(substr($truckId, 0, 1));
        $i = 1;

        foreach ($groupedStops as $key => $ordersAtLocation) {
            [$address, $city] = explode('|', $key);

            $stops[] = [
                'ids' => $ordersAtLocation->pluck('id')->toArray(), // âœ… Required by Blade
                'address' => $address,
                'city' => $city,
                'lat' => $ordersAtLocation->first()->lat,
                'lng' => $ordersAtLocation->first()->lng,
                'label' => $prefix . $i,
                'customer' => $ordersAtLocation->first()->customer_name,
                'contact' => $ordersAtLocation->first()->shop->contact_phone ?? null,
                'order' => $ordersAtLocation->pluck('order_number')->join(', '),
                'status' => $ordersAtLocation->pluck('status')->unique()->count() === 1
                    ? $ordersAtLocation->first()->status
                    : 'mixed',
            ];

            $i++;
        }

        $routes[] = [
            'truck_number' => $truckId,
            'driver_id' => $driver->id ?? null,
            'driver' => $driver->name ?? 'Unknown Driver',
            'stops' => $stops
        ];
        
    }
$date = optional($deliveries->first()->delivery_date)
    ? \Carbon\Carbon::parse($deliveries->first()->delivery_date)->toDateString()
    : now()->toDateString();
    
    

    return view('routes.driver', compact('routes', 'warehouseAddress', 'date'));
}




public function generatePdf($truck, $date)
{
    $warehouse = '4231 Liberty Blvd, South Gate, CA';

    $deliveries = Delivery::with('driver') // ðŸ‘ˆ add this line
    ->where('truck_number', $truck)
    ->whereDate('delivery_date', $date)
    ->where('is_delivery', 1)
    ->orderBy('sort_order')
    ->get();


    $driver = $deliveries->first()?->driver?->name ?? 'N/A';

    if ($deliveries->isEmpty()) {
        return view('routes.pdf', [
            'truck' => $truck,
            'date' => $date,
            'stops' => [],
            'driver' => $driver,
        ]);
    }

    // Same grouping as in view
    $groupedStops = collect();
    foreach ($deliveries as $delivery) {
        $key = $delivery->address . '|' . $delivery->city;
        if (!$groupedStops->has($key)) {
            $groupedStops[$key] = collect();
        }
        $groupedStops[$key]->push($delivery);
    }

    $stops = $groupedStops->map(function ($group) {
        return [
            'customer' => $group->first()->customer_name,
            'address' => $group->first()->address,
            'city' => $group->first()->city,
            'zip' => $group->first()->zip,
            'order_numbers' => $group->pluck('order_number')->toArray(),
            'commissions' => $group->pluck('commission')->toArray(),
            'units' => $group->first()->units, // âœ… Just one value
        'carts' => $group->pluck('cart_barcode')->unique()->toArray(), // âœ… Array of carts
        ];
    })->values()->toArray();

return view('routes.pdf', compact('truck', 'date', 'stops', 'driver'));
}




    public function generate()
    {
        return view('routes.generate');
    }

  public function optimize(Request $request)
{
    $request->validate([
        'delivery_date' => 'required|date',
        'max_stops' => 'required|integer|min:1',
    ]);

    $date = $request->input('delivery_date');
    $maxStops = $request->input('max_stops');

    // Optional: Reset previous assignments for that day
    Delivery::where('is_delivery', 1)
        ->whereDate('delivery_date', $date)
        ->update(['truck_number' => null, 'driver_id' => null]);

    $deliveries = Delivery::where('is_delivery', 1)
        ->whereDate('delivery_date', $date)
        ->get();

    if ($deliveries->isEmpty()) {
        return redirect()->route('routes.auto')->with('error', 'No deliveries to optimize for that date.');
    }

    $trucks = Truck::pluck('truck_number')->toArray();
    $drivers = Driver::pluck('id')->toArray();

    if (empty($trucks) || empty($drivers)) {
        return redirect()->route('routes.auto')->with('error', 'No trucks or drivers available.');
    }

    $truckIndex = 0;
    $truckCount = count($trucks);

    // Group by address + city
    $grouped = $deliveries->groupBy(function ($item) {
        return $item->address . '|' . $item->city;
    });

    $assignedStops = 0;

    foreach ($grouped as $group) {
        if (!isset($trucks[$truckIndex]) || !isset($drivers[$truckIndex])) {
            break;
        }

        if ($assignedStops >= $maxStops) {
            $truckIndex = ($truckIndex + 1) % $truckCount;
            $assignedStops = 0;
        }

        $truck = $trucks[$truckIndex];
        $driverId = $drivers[$truckIndex];

        foreach ($group as $delivery) {
            $delivery->truck_number = $truck;
            $delivery->driver_id = $driverId;
            $delivery->save();
        }

        $assignedStops++;
    }

    return redirect()->route('routes.auto')->with('success', 'Routes generated for ' . $date);
}

private function optimizeRouteWithGoogle($warehouseAddress, array $stops)
{
    $waypoints = implode('|', array_map('urlencode', $stops));
    $origin = urlencode($warehouseAddress);
    $destination = urlencode($warehouseAddress);
    $apiKey = env('AIzaSyCPhMXb_6VAGwwSMYj9S1udEO027E3BZT0');

    $url = "https://maps.googleapis.com/maps/api/directions/json?origin={$origin}&destination={$destination}&waypoints=optimize:true|{$waypoints}&key={$apiKey}";

    $response = json_decode(file_get_contents($url), true);

    if ($response && $response['status'] === 'OK') {
        return $response['routes'][0]['waypoint_order']; // array of indexes
    }

    return null;
}

public function updateStopStatus(Request $request)
{
    $request->validate([
        'stop_id' => 'required|array',
        'status' => 'required|in:delivered,cancelled',
        'payment_status' => 'nullable|in:paid,unpaid',
        'payment_method' => 'nullable|in:cash,check,card,transfer',
        'payment_amount' => 'nullable|numeric',
        'delivery_note' => 'nullable|string',
        'cancel_note' => 'nullable|string',
    ]);

    foreach ($request->stop_id as $id) {
        $delivery = Delivery::find($id);
        if (!$delivery) continue;

        $delivery->status = $request->status;

        if ($request->status === 'delivered') {
            $delivery->payment_status = $request->payment_status;
            $delivery->payment_method = $request->payment_method;
            $delivery->payment_amount = $request->payment_amount;
            $delivery->delivery_note = $request->delivery_note ?? '';
            $delivery->cancel_note = null; // clear old cancel note
        } elseif ($request->status === 'cancelled') {
            $delivery->payment_status = null;
            $delivery->payment_method = null;
            $delivery->payment_amount = null;
            $delivery->cancel_note = $request->cancel_note ?? '';
            $delivery->delivery_note = null; // clear old delivery note
        }

        $delivery->save();
    }

    return response()->json(['message' => 'Status updated']);
}






public function reorderStops(Request $request)
{
    $request->validate([
        'truck_number' => 'required|string',
        'order' => 'required|array'
    ]);

    $truckNumber = $request->input('truck_number');
    $orderGroups = $request->input('order');

    if (empty($orderGroups)) {
        return response()->json(['success' => false, 'message' => 'No delivery IDs received'], 400);
    }

    $firstDelivery = Delivery::where('truck_number', $truckNumber)->first();
    $driverId = $firstDelivery ? $firstDelivery->driver_id : null;

    foreach ($orderGroups as $index => $group) {
    $ids = is_array($group) ? $group : [$group];
    foreach ($ids as $deliveryId) {
        if (!is_numeric($deliveryId)) continue;
        Delivery::where('id', $deliveryId)->update([
            'truck_number' => $truckNumber,
            'sort_order' => $index,
            'driver_id' => $driverId
        ]);
    }
}


    return response()->json(['success' => true, 'message' => 'Route updated']);
}




public function updateStopTruck(Request $request)
{
    $request->validate([
        'stop_id' => 'required|exists:elitevw_sr_deliveries,id',
        'truck_number' => 'required|string',
        'driver_id' => 'nullable|exists:drivers,id'
    ]);

    $delivery = Delivery::find($request->stop_id);
    $delivery->truck_number = $request->truck_number;
    $delivery->driver_id = $request->driver_id;
    $delivery->save();

    return response()->json(['message' => 'Stop updated']);
}

    public function resetAssignments()
    {
        Delivery::whereNotNull('truck_number')
            ->orWhereNotNull('driver_id')
            ->update([
                'truck_number' => null,
                'driver_id' => null
            ]);

        return redirect()->route('routes.auto')->with('success', 'Truck and driver assignments have been reset.');
    }
}
