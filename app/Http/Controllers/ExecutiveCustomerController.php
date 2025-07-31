<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Tier;

class ExecutiveCustomerController extends Controller
{

public function index(Request $request)
{
    $status = $request->get('status');

    $query = Customer::query();

    if ($status === 'active') {
        $query->where('status', 'active');
    }

    $customers = $query->get();
    $tiers = Tier::orderBy('name')->get();

    return view('executives.customers.index', compact('customers', 'tiers'));
}


public function store(Request $request)
{
    $request->validate([
        'customer_number' => 'required|unique:elitevw_master_customers,customer_number',
        'name' => 'required|string|max:255',
        'tier_id' => 'nullable|integer|exists:elitevw_sr_tiers,id',
        'loyalty_credit' => 'nullable|numeric',
        'total_spent' => 'nullable|numeric',
        'status' => 'nullable|string|in:active,inactive',
        'street' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:255',
        'zip' => 'nullable|string|max:20',
    ]);

    Customer::create([
        'customer_number' => $request->customer_number,
        'name' => $request->name,
        'tier_id' => $request->tier_id,
        'loyalty_credit' => $request->loyalty_credit ?? 0,
        'total_spent' => $request->total_spent ?? 0,
        'status' => $request->status,
        'street' => $request->street,
        'city' => $request->city,
        'zip' => $request->zip,
        'customer_name' => $request->name,
        'customer_number' => $request->customer_number,
    ]);

    return redirect()->route('executives.customers.index')->with('success', 'Customer added successfully.');
}


public function edit($id){
    $customer = Customer::findOrFail($id);
    $tiers = Tier::orderBy('name')->get();

    return view('executives.customers.edit', compact('customer', 'tiers'));
}

public function update(Request $request, $id)
{
    $customer = Customer::findOrFail($id);

    $request->validate([
        'customer_number' => 'required|unique:elitevw_master_customers,customer_number,' . $customer->id,
        'status' => 'nullable|string|in:active,inactive',
        'loyalty_credit' => 'nullable|numeric',
        'total_spent' => 'nullable|numeric',
        'name' => 'required|string|max:255',
        'tier_id' => 'nullable|integer|exists:elitevw_sr_tiers,id',
        'loyalty_credit' => 'nullable|numeric',
        'total_spent' => 'nullable|numeric',
        'status' => 'nullable|string|in:active,inactive',
        'street' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:255',
        'zip' => 'nullable|string|max:20',

    ]);

    $customer->update([
        'customer_name' => $request->name,
        'tier_id' => $request->tier_id,
        'loyalty_credit' => $request->loyalty_credit ?? 0,
        'total_spent' => $request->total_spent ?? 0,
        'status' => $request->status,
        'street' => $request->street,
        'city' => $request->city,
        'zip' => $request->zip,
        'customer_number' => $request->customer_number,
    ]);

    return redirect()->route('executives.customers.index')->with('success', 'Customer updated successfully.');
}

public function handleImports(Request $request)
{
    $file = $request->file('import_file');

    // Handle re-import from confirmation page
    if ($request->filled('import_file') && is_string($request->import_file)) {
        $tempPath = storage_path('app/temp_customer_import.xlsx');
        file_put_contents($tempPath, base64_decode($request->import_file));
        $file = new \Symfony\Component\HttpFoundation\File\UploadedFile(
            $tempPath,
            'import.xlsx',
            null,
            null,
            true
        );
    }

    if (!$file) {
        return back()->with('error', 'The uploaded file is invalid.');
    }

    $actionType = $request->input('action_type');
    $spreadsheet = IOFactory::load($file->getRealPath());
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    if (empty($rows)) {
        return back()->with('error', 'The uploaded file is empty or incorrectly formatted.');
    }

    $headerRow = array_shift($rows);
    $headerMap = \App\Helper\CustomerImportHelper::getHeaderMap();

    $customersToImport = [];
    $duplicateProductionBarcodes = [];

    foreach ($rows as $row) {
        $customerData = [];

        foreach ($headerRow as $index => $columnHeader) {
            $trimmedHeader = trim($columnHeader);
            $mappedField = $headerMap[$trimmedHeader] ?? null;

            if ($mappedField) {
                $value = trim($row[$index] ?? '');
                $customerData[$mappedField] = $value === '' ? null : $value;
            }
        }

        // ✅ Skip if production_barcode is missing or empty
        if (!empty($customerData['customer_number'])) {
            $customersToImport[] = $customerData;

            if (\App\Models\Cim::where('customer_number', $customerData['customer_number'])->exists()) {
                $duplicateProductionBarcodes[] = $customerData['customer_number'];
            }
        }
    }

    if (!$actionType && !empty($duplicateCustomerNumbers)) {
        return view('customers.confirm-import', [
            'duplicates' => $duplicateCustomerNumbers,
            'originalFile' => base64_encode(file_get_contents($file->getRealPath()))
        ]);
    }

    foreach ($customersToImport as $data) {
        if (
            $actionType === 'skip' &&
            array_key_exists('customer_number', $data) &&
            \App\Models\Customer::where('customer_number', $data['customer_number'])->exists()
        ) {
            continue;
        }

        \App\Models\Customer::updateOrCreate(
            ['customer_number' => $data['customer_number']],
            $data
        );
    }

    return redirect()->route('customers.index')->with('success', 'Customer data imported successfully.');
}


}
