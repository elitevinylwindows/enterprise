<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WindowRenderController extends Controller
{
  public function render(Request $request, $series, $code)
{
    $windowInchesW = $request->query('width', 60);
    $windowInchesH = $request->query('height', 48);

    return view('components.window-config', [
        'series' => strtolower($series),
        'code' => strtoupper($code),
        'width' => (int) $windowInchesW,
        'height' => (int) $windowInchesH,
        'windowInchesW' => $windowInchesW,
        'windowInchesH' => $windowInchesH,
    ]);
}

}
