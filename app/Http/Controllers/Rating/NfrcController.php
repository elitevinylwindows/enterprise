<?php

namespace App\Http\Controllers\Rating;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NfrcController extends Controller
{
    /** Page */
    public function index()
    {
        return view('nfrc.index');
    }

    /** GET /api/nfrc/types */
    public function types()
    {
        $rows = DB::connection('elitevw_ratings_nfrc')
            ->table('nfrc_window_types')
            ->orderBy('name')->get(['id','name','slug']);
        return response()->json($rows);
    }

    /** GET /api/nfrc/lines?type_id= */
    public function lines(Request $r)
    {
        $typeId = (int)$r->query('type_id', 0);
        $q = DB::connection('elitevw_ratings_nfrc')->table('nfrc_product_lines');
        if ($typeId) $q->where('window_type_id', $typeId);
        $rows = $q->orderBy('series_model')->orderBy('product_line')
                  ->get(['id','series_model','product_line','product_line_url']);
        return response()->json($rows);
    }

    /** GET /api/nfrc/models?type_id=  (distinct series_model for selected type) */
    public function models(Request $r)
    {
        $typeId = (int)$r->query('type_id', 0);
        $q = DB::connection('elitevw_ratings_nfrc')->table('nfrc_product_lines')
             ->select('series_model')->distinct();
        if ($typeId) $q->where('window_type_id', $typeId);
        $rows = $q->orderBy('series_model')->pluck('series_model');
        return response()->json($rows);
    }

    /** GET /api/nfrc/ratings?product_line_id= */
    public function ratings(Request $r)
    {
        $lineId = (int)$r->query('product_line_id', 0);
        if (!$lineId) return response()->json([]);

        $pl = DB::connection('elitevw_ratings_nfrc')->table('nfrc_product_lines')->find($lineId);
        $ratings = DB::connection('elitevw_ratings_nfrc')->table('nfrc_ratings')
            ->where('product_line_id', $lineId)
            ->orderBy('cpd_number')
            ->get(['id','cpd_number','manufacturer_code','u_factor','shgc','vt','condensation_res','product_description']);

        return response()->json([
            'product_line' => $pl,
            'ratings'      => $ratings,
        ]);
    }
}
