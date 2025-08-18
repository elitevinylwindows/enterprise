<?php

namespace App\Http\Controllers\Master\Prices;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Master\Prices\Matrice;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MatriceController extends Controller
{
    public function index(Request $request)
    {
        $prices = DB::table('elitevw_master_price_price_matrices')
            ->leftJoin('elitevw_master_series', 'elitevw_master_price_price_matrices.series_id', '=', 'elitevw_master_series.id')
            ->leftJoin('elitevw_master_series_types', 'elitevw_master_price_price_matrices.series_type_id', '=', 'elitevw_master_series_types.id')
            ->select(
                'elitevw_master_price_price_matrices.*',
                'elitevw_master_series.series as series',
                'elitevw_master_series_types.series_type as type'
            );

        if (isset($request->series)) {
            $prices->where('elitevw_master_price_price_matrices.series_id', $request->series);
        }

        if (isset($request->series_type_id)) {
            $prices->where('elitevw_master_price_price_matrices.series_type_id', $request->series_type_id);
        }

        $prices = $prices->get();
// Apply markup to each price record
$prices->transform(function ($item) {
    $markup = DB::table('elitevw_master_markup')
        ->where('series_id', $item->series_id)
        ->value('percentage');

    if ($markup) {
        $item->price = round($item->price * (1 + $markup / 100), 2);
    }

    return $item;
});

        $allSeries = DB::table('elitevw_master_series')->pluck('series')->unique()->sort()->values();
        $allTypesJson = DB::table('elitevw_master_series_types')->pluck('series_type');
        $allTypes = collect();

        foreach ($allTypesJson as $json) {
            $decoded = json_decode($json, true);
            if (is_array($decoded)) {
                $allTypes = $allTypes->merge($decoded);
            } elseif (is_string($json)) {
                $allTypes->push($json);
            }
        }

        $allTypes = $allTypes->unique()->sort()->values();

        $seriesForModal = DB::table('elitevw_master_series')->select('id', 'series')->get();
        $typesForModal = DB::table('elitevw_master_series_types')->select('id', 'series_type')->get();

        $widths = $prices->pluck('width')->unique()->sort()->values();
        $heights = $prices->pluck('height')->unique()->sort()->values();

        return view('master.prices.matrice.index', compact(
            'prices',
            'widths',
            'heights',
            'allSeries',
            'allTypes',
            'seriesForModal',
            'typesForModal'
        ));
    }

    public function import(Request $request)
    {
        $request->validate([
            'series_id' => 'required|exists:elitevw_master_series,id',
            'series_type_id' => 'required|exists:elitevw_master_series_types,id',
            'import_file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

$spreadsheet = IOFactory::load($request->file('import_file'));
$sheet = $spreadsheet->getActiveSheet();
$rows = $sheet->toArray();

       $heightRow = $rows[0];
unset($rows[0]);

foreach ($rows as $row) {
    $width = $row[0];

    for ($i = 1; $i < count($row); $i++) {
        $height = $heightRow[$i] ?? null;
        $price = $row[$i] ?? null;

        if ($width && $height && $price !== null) {
            DB::table('elitevw_master_price_price_matrices')->insert([
                'series_id' => $request->series_id,
                'series_type_id' => $request->series_type_id,
                'width' => $width,
                'height' => $height,
                'price' => $price,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}


        return back()->with('success', 'Prices imported.');
    }

    public function checkPrice(Request $request)
    {
        $request->validate([
            'series_id' => 'required',
            'series_type_id' => 'required',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
        ]);

        $price = DB::table('elitevw_master_price_price_matrices')
            ->where('series_id', $request->series_id)
            ->where('series_type_id', $request->series_type_id)
            ->where('width', $request->width)
            ->where('height', $request->height)
            ->value('price');

        return response()->json(['price' => $price]);
    }

    public function getTypes($seriesId)
    {
        $records = DB::table('elitevw_master_series_types')
            ->where('series_id', $seriesId)
            ->select('id', 'series_type')
            ->get();

        $types = [];

        foreach ($records as $record) {
            $decoded = json_decode($record->series_type, true);
            if (is_array($decoded)) {
                foreach ($decoded as $value) {
                    $types[] = [
                        'id' => $record->id,
                        'series_type' => $value
                    ];
                }
            } else {
                $types[] = [
                    'id' => $record->id,
                    'series_type' => $record->series_type
                ];
            }
        }

        return response()->json($types);
    }
}
