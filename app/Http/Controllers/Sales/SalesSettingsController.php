<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Sales\SalesSetting;

class SalesSettingsController extends Controller
{
    public function index()
    {
        $settings = SalesSetting::all()->pluck('value', 'key')->toArray();
        return view('sales.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            SalesSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->back()->with('success', 'Settings updated.');
    }
}
