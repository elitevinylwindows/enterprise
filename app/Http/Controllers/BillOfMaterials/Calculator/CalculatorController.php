<?php

namespace App\Http\Controllers\BillOfMaterials\Calculator;

use App\Http\Controllers\Controller;
use App\Models\BillOfMaterials\Calculator\Calculator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\FormOption;
use App\Models\Series;




class CalculatorController extends Controller
{

public function index(Request $request)
{
    $selectedColor = $request->get('color', 'White');
    $seriesList = Series::all(); // already used
    $selectedSeries = $request->get('series');

    $menuOptions = [
    'Frame Type'     => DB::table('elitevw_bom_menu_frametype')->where('color', $selectedColor)->get(),
    'Grid Type'      => DB::table('elitevw_bom_menu_gridtype')->where('color', $selectedColor)->get(),
    'Lock Cover'     => DB::table('elitevw_bom_menu_lockcover')->where('color', $selectedColor)->get(),
    'Water Flow'     => DB::table('elitevw_bom_menu_waterflow')->where('color', $selectedColor)->get(),
    'Mull Cap'       => DB::table('elitevw_bom_menu_mullcap')->where('color', $selectedColor)->get(),
   
    'Mull Stack'     => DB::table('elitevw_bom_menu_mullstack')->where('color', $selectedColor)->get(),
    'Stop'           => DB::table('elitevw_bom_menu_stop')->where('color', $selectedColor)->get(),
    'Roller Track'   => DB::table('elitevw_bom_menu_rollertrack')->where('color', $selectedColor)->get(),
    'Double Tape'    => DB::table('elitevw_bom_menu_doubletape')->where('color', $selectedColor)->get(),
    'Snapping'       => DB::table('elitevw_bom_menu_snapping')->where('color', $selectedColor)->get(),
];


$menuOptions += [
    'Strike'                  => DB::table('elitevw_bom_menu_strike')->get(),
    'Spacer'                  => DB::table('elitevw_bom_menu_spacer')->get(),
    'Strike Screw'            => DB::table('elitevw_bom_menu_strikescrew')->get(),
     'Mesh'           => DB::table('elitevw_bom_menu_mesh')->get(),
    'Screen'                  => DB::table('elitevw_bom_menu_screen')->get(),
    'Tension Springs'         => DB::table('elitevw_bom_menu_tensionspring')->get(),
    'Pullers'                 => DB::table('elitevw_bom_menu_pullers')->get(),
    'Corners'                 => DB::table('elitevw_bom_menu_corners')->get(),
    'Spline'                  => DB::table('elitevw_bom_menu_spline')->get(),
    'Warning Label'           => DB::table('elitevw_bom_menu_warninglabel')->get(),
    'Aluminum Reinforcement'  => DB::table('elitevw_bom_menu_aluminumreinforcement')->get(),
    'Steel Reinforcement'     => DB::table('elitevw_bom_menu_steelreinforcement')->get(),
    'Reinforcement Material'  => DB::table('elitevw_bom_menu_reinforcementmaterial')->get(),
    'Mull Screw'              => DB::table('elitevw_bom_menu_mullscrew')->get(),
    'Interlock Reinforcement' => DB::table('elitevw_bom_menu_interlockreinforcement')->get(),
    'Rollers'                 => DB::table('elitevw_bom_menu_rollers')->get(),
    'Interlock'               => DB::table('elitevw_bom_menu_interlock')->get(),
    'Sash'                    => DB::table('elitevw_bom_menu_sash')->get(),
    'Elite Label'             => DB::table('elitevw_bom_menu_elitelabel')->get(),
    'Setting Block'           => DB::table('elitevw_bom_menu_settingblock')->get(),
    'Night Lock'              => DB::table('elitevw_bom_menu_nightlock')->get(),
    'Anti Theft'              => DB::table('elitevw_bom_menu_antitheft')->get(),
    'AMMA Label'              => DB::table('elitevw_bom_menu_ammalabel')->get(),
    'Grid Pattern'            => DB::table('elitevw_bom_menu_gridpattern')->get(),
    'Lock Type'               => DB::table('elitevw_bom_menu_locktype')->get(),
];


    return view('bill_of_material.calculator.index', compact('menuOptions', 'seriesList', 'selectedSeries', 'selectedColor'));
}

public function calculateNeedCost(Request $request)
{
    $width = floatval($request->input('width'));
    $height = floatval($request->input('height'));
    $itemName = $request->input('item'); // dropdown value

    $priceItem = DB::table('prices')
        ->where('material_name', $itemName)
        ->first();

    if (!$priceItem) {
        return response()->json(['error' => 'Item not found'], 404);
    }

    $need = 2 * ($width + $height); // total linear inches
    $unitCost = floatval($priceItem->lin_pcs); // already cost per inch
    $totalCost = round($unitCost * $need, 3);

    return response()->json([
        'need' => round($need, 2),
        'measure' => 'L In',
        'cost' => round($unitCost, 3),
        'total' => $totalCost,
        'sold_by' => $priceItem->sold_by,
        'unit' => $priceItem->unit,
    ]);
}


public function show($slug)
{
    // Find series by slug
    $series = \App\Models\Series::where('slug', $slug)->firstOrFail();

    // Redirect to main configurator with query
    return redirect()->route('calculator.index', [
        'series' => $series->slug
    ]);
}



}



