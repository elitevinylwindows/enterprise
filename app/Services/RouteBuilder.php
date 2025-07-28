<?php

namespace App\Services;

use App\Models\Delivery;
use Illuminate\Support\Collection;

class RouteBuilder
{
    public static function generateFromDeliveries(Collection $deliveries): array
    {
        $grouped = [];

        foreach ($deliveries as $delivery) {
            $date = $delivery->delivery_date->toDateString();

            $truckId = $delivery->truck_number ?? 'Unassigned';
            $driverId = $delivery->driver_id;

            if (!isset($grouped[$date])) {
                $grouped[$date] = [];
            }

            if (!isset($grouped[$date][$truckId])) {
                $grouped[$date][$truckId] = [
                    'truck_id' => $truckId,
                    'driver_id' => $driverId,
                    'driver' => optional($delivery->driver)->name,
                    'stops' => [],
                ];
            }

            // Group by address + city (as stop)
            $key = $delivery->address . '|' . $delivery->city;

            if (!isset($grouped[$date][$truckId]['stops'][$key])) {
                $grouped[$date][$truckId]['stops'][$key] = [
                    'address' => $delivery->address,
                    'city' => $delivery->city,
                    'contact' => $delivery->contact_phone,
                    'customer' => $delivery->customer_name,
                    'order_numbers' => [],
                    'ids' => [],
                    'status' => $delivery->status ?? 'pending',
                ];
            }

            $grouped[$date][$truckId]['stops'][$key]['order_numbers'][] = $delivery->order_number;
            $grouped[$date][$truckId]['stops'][$key]['ids'][] = $delivery->id;
        }

        // Final formatting (re-index stops)
        $result = [];

        foreach ($grouped as $date => $routes) {
            $result[$date] = [];

            foreach ($routes as $truckRoute) {
                $truckRoute['stops'] = array_values($truckRoute['stops']); // reset keys
                $result[$date][] = $truckRoute;
            }
        }

        return $result;
    }
}
