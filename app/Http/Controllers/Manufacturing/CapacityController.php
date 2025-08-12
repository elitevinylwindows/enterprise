<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Capacity;

class CapacityController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = Capacity::query();

        // Filter based on status selection
        if ($status === 'under') {
            $query->whereRaw('`actual` / NULLIF(`limit`, 0) < 0.8');
        } elseif ($status === 'near') {
            $query->whereRaw('(`actual` / NULLIF(`limit`, 0)) >= 0.8 AND (`actual` / NULLIF(`limit`, 0)) < 1');
        } elseif ($status === 'full') {
            $query->whereRaw('(`actual` / NULLIF(`limit`, 0)) >= 1');
        }

        $capacities = $query->orderBy('id')->get();

        return view('manufacturing.capacity.index', [
            'capacities' => $capacities,
            'status' => $status,
        ]);
    }
}
