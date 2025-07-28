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
        'customer_number' => 'required|unique:elitevw_sr_customers,customer_number',
        'name' => 'required|string|max:255',
        'tier' => 'nullable|string',
        'loyalty_credit' => 'nullable|numeric',
        'total_spent' => 'nullable|numeric',
    ]);

    Customer::create([
        'customer_number' => $request->customer_number,
        'name' => $request->name,
        'tier' => $request->tier,
        'loyalty_credit' => $request->loyalty_credit ?? 0,
        'total_spent' => $request->total_spent ?? 0,
    ]);

    return redirect()->route('executives.customers.index')->with('success', 'Customer added successfully.');
}


public function edit($id){
    $customer = Customer::findOrFail($id);
    $tiers = Tier::orderBy('name')->get();

    return view('executives.customers.edit', compact('customer', 'tiers'));
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
