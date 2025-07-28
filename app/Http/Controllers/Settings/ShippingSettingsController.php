<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ShippingSettingsController extends Controller
{
 
    public function index()
    {
        return view('sr.settings.index');
    }

    /**
     * Truncate the elitevw_sr_orders, _cims, and _deliveries tables.
     */
    public function truncateShippingData(Request $request)
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');

            DB::statement('TRUNCATE TABLE elitevw_sr_orders');
            DB::statement('TRUNCATE TABLE elitevw_sr_cims');
            DB::statement('TRUNCATE TABLE elitevw_sr_deliveries');

            DB::statement('SET FOREIGN_KEY_CHECKS = 1');

            return back()->with('success', 'Shipping-related tables have been truncated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}


