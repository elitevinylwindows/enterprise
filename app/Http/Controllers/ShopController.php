<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ShopImport;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::all();
        return view('shops.index', compact('shops'));
    }

    public function create()
    {
        return view('shops.create');
    }

public function show($id)
{
    return abort(404);
}



public function fetchCustomerName($customer)
{
    $delivery = \App\Models\Delivery::where('customer', $customer)
        ->whereNotNull('customer_name')
        ->first();

    if ($delivery) {
        return response()->json([
            'customer_name' => $delivery->customer_name
        ]);
    }

    return response()->json(['customer_name' => '']);
}



    public function store(Request $request)
    {
        $request->validate([
            'customer' => 'required|string',
            'customer_name' => 'required|string',
             'email' => 'required|string',
              'contact_phone' => 'required|string',
            'address' => 'required|string',
            'city'    => 'required|string',
            'zip'     => 'required|string',
        ]);

        Shop::create($request->only('customer', 'customer_name', 'email', 'contact_phone', 'address', 'city', 'zip'));

        return redirect()->route('shops.index')->with('success', 'Shop added successfully.');
    }

    public function edit(Shop $shop)
    {
        return view('shops.edit', compact('shop'));
    }

    public function update(Request $request, Shop $shop)
    {
        $request->validate([
            'customer' => 'required|string',
            'customer_name' => 'required|string',
            'email' => 'required|string',
              'contact_phone' => 'required|string',
            'address' => 'required|string',
            'city'    => 'required|string',
            'zip'     => 'required|string',
        ]);

        $shop->update($request->only('customer', 'customer_name', 'email', 'contact_phone', 'address', 'city', 'zip'));

        return redirect()->route('shops.index')->with('success', 'Shop updated successfully.');
    }

    public function destroy(Shop $shop)
    {
        $shop->delete();
        return redirect()->route('shops.index')->with('success', 'Shop deleted successfully.');
    }
    
    public function fetchShop($customer)
{
    $shop = \App\Models\Shop::where('customer', $customer)->first();

    if ($shop) {
        return response()->json([
            'success' => true,
            'shop' => $shop
        ]);
    }

    return response()->json(['success' => false]);
}


    public function importForm()
    {
        return view('shops.import');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new ShopImport, $request->file('file'));
        return redirect()->route('shops.index')->with('success', 'Shops imported successfully.');
    }
}
