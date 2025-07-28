<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery;
use Carbon\Carbon;
use App\Models\Truck;
use App\Models\Driver;



class PlanRouteController extends Controller
{


public function createDateSection(Request $request)
{
    $request->validate([
        'delivery_date' => 'required|date',
    ]);

    $date = Carbon::parse($request->delivery_date)->toDateString();

    // Check if there are already deliveries for this date
    $exists = Delivery::whereDate('delivery_date', $date)->exists();

    if ($exists) {
        return response()->json(['message' => 'Route already exists for this date.'], 409);
    }

    // Pre-create empty placeholders (optional logic — for display only)
    return response()->json([
        'success' => true,
        'date' => $date,
        'message' => 'Planned route section created.',
    ]);
}

public function planMapView($date)
{
    $deliveries = Delivery::where('is_delivery', 1)
        ->whereDate('delivery_date', $date)
        ->whereNotNull('truck_number')
        ->whereNotNull('driver_id')
        ->get();

    $warehouseAddress = config('app.warehouse_address', '4231 Liberty Blvd, South Gate, CA');

    $groupedRoutes = [];

    $grouped = $deliveries->groupBy('truck_number');

    foreach ($grouped as $truck => $group) {
        if (!$truck) continue;

        $driverId = optional($group->first())->driver_id;
        $driver = optional($group->first()->driver)->name ?? 'N/A';

        $stops = $group->groupBy(fn($item) => $item->address . '|' . $item->city)->map(function ($stopGroup) {
            return [
                'label' => null,
                'ids' => $stopGroup->pluck('id'),
                'customer_name' => $stopGroup->first()->customer_name,
                'address' => $stopGroup->first()->address,
                'city' => $stopGroup->first()->city,
                'contact' => $stopGroup->first()->contact_phone,
                'order_numbers' => $stopGroup->pluck('order_number')->unique(),
                'status' => $stopGroup->first()->status ?? 'pending',
            ];
        })->values()->toArray();

        $groupedRoutes[] = [
            'truck_id' => $truck,
            'driver_id' => $driverId,
            'driver' => $driver,
            'stops' => $stops,
        ];
    }

    return view('routes.map', [
        'groupedRoutes' => [$date => $groupedRoutes],
        'warehouseAddress' => $warehouseAddress,
        'date' => $date,
    ]);
}



public function resetDate($date)
{
    Delivery::whereDate('delivery_date', $date)
        ->update(['truck_number' => null, 'driver_id' => null]);

    return redirect()->route('routes.plan')->with('success', 'Assignments reset for ' . $date);
}

public function generateDate($date)
{
    $request = new \Illuminate\Http\Request([
        'delivery_date' => $date,
        'max_stops' => 10 // Default value or fetch from DB/UI
    ]);

    return $this->planOptimize($request);
}


public function planRouteView()
{
    $warehouseAddress = '4231 Liberty Blvd, South Gate, CA'; // Change as needed

    // Fetch all planned deliveries grouped by delivery_date
    $deliveries = Delivery::where('is_delivery', 1)
        ->whereNotNull('delivery_date')
        ->orderBy('delivery_date')
        ->get()
        ->groupBy(function ($item) {
            return Carbon::parse($item->delivery_date)->toDateString();
        });

    $groupedRoutes = [];

    foreach ($deliveries as $date => $dailyDeliveries) {
        $routes = [];

        $grouped = $dailyDeliveries->groupBy('truck_number');

        foreach ($grouped as $truck => $group) {
    if (!$truck) continue;

    $driverId = optional($group->first())->driver_id;
    $driver = optional($group->first()->driver)->name ?? 'N/A';

    // Group stops by unique address + city
    $stopsCollection = $group->groupBy(fn($item) => $item->address . '|' . $item->city)->map(function ($stopGroup) {
        return [
            'label' => null,
            'ids' => $stopGroup->pluck('id'),
            'customer_name' => $stopGroup->first()->customer_name,
            'address' => $stopGroup->first()->address,
            'city' => $stopGroup->first()->city,
            'contact' => $stopGroup->first()->contact_phone,
'order_numbers' => $stopGroup->pluck('order_number')->unique()->toArray(),
            'status' => $stopGroup->first()->status ?? 'pending',
        ];
    });

    // Prepare addresses for Google optimization
    $stops = $stopsCollection->values()->toArray();
    $addresses = array_map(fn($s) => $s['address'] . ', ' . $s['city'], $stops);

    $optimizedOrder = $this->optimizeRouteWithGoogle($warehouseAddress, $addresses);

    // Reorder the stops based on optimized order
    if (is_array($optimizedOrder)) {
        $stops = array_map(fn($index) => $stops[$index], $optimizedOrder);
    }
    
    
    
$prefix = is_numeric($truck) ? chr(65 + intval($truck) - 1) : strtoupper(substr($truck, 0, 1));
$i = 1;

foreach ($stops as &$stop) {
    $stop['label'] = $prefix . $i;
    $i++;
}






    $routes[] = [
        'truck_id' => $truck,
        'driver_id' => $driverId,
        'driver' => $driver,
        'stops' => $stops,
    ];
}


        $groupedRoutes[$date] = $routes;
    }

    return view('routes.plan', [
        'warehouseAddress' => $warehouseAddress,
        'groupedRoutes' => $groupedRoutes,
    ]);
}



public function moveToAuto(Request $request, $date)
{
    // Mark deliveries as moved to auto view without changing the date
    \App\Models\Delivery::where('is_delivery', 1)
        ->whereDate('delivery_date', $date)
        ->update([
            'moved_to_auto' => true, // 🆕 you'll need to add this column in your deliveries table
        ]);

    return redirect()->route('routes.plan')->with('success', 'Deliveries for ' . $date . ' moved to Auto Route view.');
}




  public function planOptimize(Request $request)
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
        return redirect()->route('routes.plan')->with('error', 'No deliveries to optimize for that date.');
    }

    $trucks = Truck::pluck('truck_number')->toArray();
    $drivers = Driver::pluck('id')->toArray();

    if (empty($trucks) || empty($drivers)) {
        return redirect()->route('routes.plan')->with('error', 'No trucks or drivers available.');
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

    return redirect()->route('routes.plan')->with('success', 'Routes generated for ' . $date);
}

private function optimizeRouteWithGoogle($warehouseAddress, array $stops)
{
    $waypoints = implode('|', array_map('urlencode', (array) $stops)); // Defensive cast
    $origin = urlencode($warehouseAddress);
    $destination = urlencode($warehouseAddress);
    $apiKey = config('services.google_maps.api_key'); // or env('GOOGLE_MAPS_KEY')

    $url = "https://maps.googleapis.com/maps/api/directions/json?origin={$origin}&destination={$destination}&waypoints=optimize:true|{$waypoints}&key={$apiKey}";

    $response = json_decode(file_get_contents($url), true);

    if ($response && $response['status'] === 'OK') {
        return $response['routes'][0]['waypoint_order'];
    }

    return null;
}

}
