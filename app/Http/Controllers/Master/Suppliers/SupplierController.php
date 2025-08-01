<?php

namespace App\Http\Controllers\Master\Suppliers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Suppliers\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->get();
        return view('master.suppliers.index', compact('suppliers'));
    }

    public function store(Request $request)
{
    $request->validate([
        'supplier_number'   => 'required|string|max:50',
        'supplier_type'     => 'required|in:individual,organization',
        'name'              => 'required|string|max:255',
        'street'            => 'nullable|string|max:255',
        'city'              => 'nullable|string|max:100',
        'zip'               => 'nullable|string|max:20',
        'country'           => 'nullable|string|max:100',
        'status'            => 'required|in:active,inactive',
        'phone'             => 'nullable|string|max:50',
        'email'             => 'nullable|string|max:255',
        'website'           => 'nullable|string|max:255',
        'currency'          => 'nullable|string|max:10',
        'currency_symbol'   => 'nullable|string|max:5',
        'ein_number'        => 'nullable|string|max:50',
'license_number'    => 'nullable|string|max:50',
'supplier_group'    => 'nullable|string|max:100',
'labels'            => 'nullable|string|max:100',
'disable_online_payment' => 'nullable|boolean',

    ]);

    \App\Models\Master\Suppliers\Supplier::create([
        'supplier_number'   => $request->supplier_number,
        'supplier_type'     => $request->supplier_type,
        'name'              => $request->name,
        'street'            => $request->street,
        'city'              => $request->city,
        'zip'               => $request->zip,
        'country'           => $request->country,
        'status'            => $request->status,
        'phone'             => $request->phone,
        'email'             => $request->email,
        'website'           => $request->website,
        'client_group'      => $request->client_group,
        'currency'          => $request->currency,
        'currency_symbol'   => $request->currency_symbol,
        'ein_number'        => $request->ein_number,
'license_number'    => $request->license_number,
'supplier_group'    => $request->supplier_group, // was client_group
'labels'            => $request->labels,         // was label
'disable_online_payment' => $request->has('disable_online_payment') ? 1 : 0, // was disable_payment

    ]);

    return redirect()->route('master.suppliers.index')
                     ->with('success', 'Supplier added successfully.');
}


 public function edit($id)
{
    $supplier = \App\Models\Master\Suppliers\Supplier::findOrFail($id);
    return view('master.suppliers.edit', compact('supplier'));
}



   public function update(Request $request, $id)
{
    $request->validate([
        'supplier_number'   => 'required|string|max:50',
        'supplier_type'     => 'required|in:individual,organization',
        'name'              => 'required|string|max:255',
        'street'            => 'nullable|string|max:255',
        'city'              => 'nullable|string|max:100',
        'zip'               => 'nullable|string|max:20',
        'country'           => 'nullable|string|max:100',
        'status'            => 'required|in:active,inactive',
        'phone'             => 'nullable|string|max:50',
        'email'             => 'nullable|string|max:255',
        'website'           => 'nullable|string|max:255',
        'currency'          => 'nullable|string|max:10',
        'currency_symbol'   => 'nullable|string|max:5',
        'ein_number'        => 'nullable|string|max:50',
'license_number'    => 'nullable|string|max:50',
'supplier_group'    => 'nullable|string|max:100',
'labels'            => 'nullable|string|max:100',
'disable_online_payment' => 'nullable|boolean',

    ]);

    $supplier = \App\Models\Master\Suppliers\Supplier::findOrFail($id);

    $supplier->update([
        'supplier_number'   => $request->supplier_number,
        'supplier_type'     => $request->supplier_type,
        'name'              => $request->name,
        'street'            => $request->street,
        'city'              => $request->city,
        'zip'               => $request->zip,
        'country'           => $request->country,
        'status'            => $request->status,
        'phone'             => $request->phone,
        'email'             => $request->email,
        'website'           => $request->website,
        'client_group'      => $request->client_group,
        'currency'          => $request->currency,
        'currency_symbol'   => $request->currency_symbol,
        'ein_number'        => $request->ein_number,
'license_number'    => $request->license_number,
'supplier_group'    => $request->supplier_group, // was client_group
'labels'            => $request->labels,         // was label
'disable_online_payment' => $request->has('disable_online_payment') ? 1 : 0, // was disable_payment

    ]);

    return redirect()->route('master.suppliers.index')
                     ->with('success', 'Supplier updated successfully.');
}


    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->back()->with('success', 'Supplier deleted successfully.');
    }
}
