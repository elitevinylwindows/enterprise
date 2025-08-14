<?php
// app/Http/Controllers/Manufacturing/DashboardController.php
namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $station = $user->station; // null for non-station users

        if ($station) {
            // map ui_key → view partial
            $map = config('stations.layouts', []); // see step 6 (optional)
            $partial = $map[$station->ui_key] ?? 'manufacturing.stations.layouts.default';

            // Full-page host that includes the station partial
            return view('manufacturing.dashboard.station_host', [
                'station' => $station,
                'partial' => View::exists($partial) ? $partial : 'manufacturing.stations.layouts.default',
            ]);
        }

        // Fallback for non-station users (admins/managers)
        return view('manufacturing.dashboard.index'); // your general dashboard
    }
}
