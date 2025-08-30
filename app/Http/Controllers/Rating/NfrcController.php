<?php

namespace App\Http\Controllers\Rating;

use App\Http\Controllers\Controller; // ✅
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Rating\NfrcWindowType;
use App\Models\Rating\NfrcProductLine;

class NfrcController extends Controller
{
    public function index()
    {
        return view('rating.nfrc.index'); // your 3-card search UI
    }

    public function types()
    {
        return response()->json(
            NfrcWindowType::orderBy('name')->get(['id','name','slug'])
        );
    }

    public function models(Request $request)
    {
        $typeId = (int)$request->query('type_id', 0);
        $q = NfrcProductLine::query()->select('series_model')->distinct();
        if ($typeId) $q->where('window_type_id', $typeId);
        return response()->json($q->orderBy('series_model')->pluck('series_model'));
    }

    public function lines(Request $request)
    {
        $typeId = (int)$request->query('type_id', 0);
        $q = NfrcProductLine::query()->select(['id','series_model','product_line','product_line_url','is_energy_star']);
        if ($typeId) $q->where('window_type_id', $typeId);
        return response()->json($q->orderBy('series_model')->orderBy('product_line')->get());
    }

    public function ratings(Request $request)
    {
        $lineId = (int)$request->query('product_line_id', 0);
        if (!$lineId) return response()->json(['product_line'=>null,'ratings'=>[]]);

        $pl = DB::table('elitevw_rating_product_lines')->find($lineId);
        $ratings = DB::table('elitevw_rating_ratings')
            ->where('product_line_id', $lineId)
            ->orderBy('cpd_number')
            ->get(['id','cpd_number','manufacturer_code','u_factor','shgc','vt','condensation_res','product_description']);

        return response()->json(['product_line' => $pl, 'ratings' => $ratings]);
    }

    public function export(Request $request)
    {
        // stub for CSV/XLSX export
        return response('Coming soon', 200);
    }
}
