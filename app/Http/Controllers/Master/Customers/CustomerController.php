<?php

namespace App\Http\Controllers\Master\Customers;

use App\Helper\FirstServe;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Customers\Customer;
use App\Models\Tier;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
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

    return view('master.customers.index', compact('customers', 'tiers'));
}


  public function store(Request $request)
    {
        $request->validate([
            'customer_number' => 'required|unique:elitevw_master_customers,customer_number',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'tier_id' => 'nullable|integer|exists:elitevw_sr_tiers,id',
            'loyalty_credit' => 'nullable|numeric',
            'total_spent' => 'nullable|numeric',
            'status' => 'nullable|string|in:active,inactive',
            'billing_address' => 'nullable|string|max:255',
            'billing_city' => 'nullable|string|max:50',
            'billing_zip' => 'nullable|string|max:20',
            'billing_state' => 'nullable|string|max:255',
            'billing_zip' => 'nullable|string|max:20',
            'billing_country' => 'nullable|string|max:255',
            'billing_phone' => 'nullable|string|max:20',
            'billing_fax' => 'nullable|string|max:20',
            'delivery_address' => 'nullable|string|max:255',
            'delivery_city' => 'nullable|string|max:50',
            'delivery_zip' => 'nullable|string|max:20',
            'delivery_state' => 'nullable|string|max:255',
            'delivery_zip' => 'nullable|string|max:20',
            'delivery_country' => 'nullable|string|max:255',
            'delivery_phone' => 'nullable|string|max:20',
            'delivery_fax' => 'nullable|string|max:20'
        ]);
        try {
            DB::beginTransaction();
            $customer = Customer::create([
                'customer_number' => $request->customer_number,
                'customer_name' => $request->name,
                'email' => $request->email,
                'tier_id' => $request->tier_id,
                'loyalty_credit' => $request->loyalty_credit ?? 0,
                'total_spent' => $request->total_spent ?? 0,
                'status' => $request->status,
                'billing_address' => $request->billing_address,
                'billing_city' => $request->billing_city,
                'billing_zip' => $request->billing_zip,
                'billing_state' => $request->billing_state,
                'billing_zip' => $request->billing_zip,
                'billing_country' => $request->billing_country,
                'billing_phone' => $request->billing_phone,
                'billing_fax' => $request->billing_fax,
                'delivery_address' => $request->delivery_address,
                'delivery_city' => $request->delivery_city,
                'delivery_zip' => $request->delivery_zip,
                'delivery_state' => $request->delivery_state,
                'delivery_zip' => $request->delivery_zip,
                'delivery_country' => $request->delivery_country,
                'delivery_phone' => $request->delivery_phone,
                'delivery_fax' => $request->delivery_fax,
            ]);

            $firstServe = new FirstServe();
            $serveCustomer =  $firstServe->createCustomer($customer);

            if ($serveCustomer) {
                $customer->update([
                    'serve_customer_id' => $serveCustomer['id'],
                ]);
            }
            DB::commit();
            return redirect()->route('master.customers.index')->with('success', 'Customer added successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to add customer: ' . $e->getMessage());
        }
    }


public function edit($id){
    $customer = Customer::findOrFail($id);
    $tiers = Tier::orderBy('name')->get();

    return view('master.customers.edit', compact('customer', 'tiers'));
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'customer_number'    => 'required|string|max:255|unique:elitevw_master_customers,customer_number,' . $id,
        'customer_name'      => 'required|string|max:255',
        'email'              => 'nullable|email|max:255',
        'tier'               => 'nullable|string|max:255',
        'status'             => 'required|in:active,inactive',
        'billing_address'    => 'nullable|string|max:255',
        'billing_city'       => 'nullable|string|max:255',
        'billing_state'      => 'nullable|string|max:255',
        'billing_zip'        => 'nullable|string|max:20',
        'billing_country'    => 'nullable|string|max:255',
        'billing_phone'      => 'nullable|string|max:30',
        'billing_fax'        => 'nullable|string|max:30',
        'delivery_address'   => 'nullable|string|max:255',
        'delivery_city'      => 'nullable|string|max:255',
        'delivery_state'     => 'nullable|string|max:255',
        'delivery_zip'       => 'nullable|string|max:20',
        'delivery_country'   => 'nullable|string|max:255',
        'delivery_phone'     => 'nullable|string|max:30',
        'delivery_fax'       => 'nullable|string|max:30',
    ]);

    try
    {

        DB::beginTransaction();
        $customer = Customer::findOrFail($id);
        $customer->update($validated);

        if(isset($customer->serve_customer_id) && $customer->serve_customer_id) {
            $firstServe = new FirstServe();
            $serveCustomer =  $firstServe->updateCustomer($customer);
        }
        else {
            $firstServe = new FirstServe();
            $serveCustomer =  $firstServe->createCustomer($customer);
        }

        if($serveCustomer) {
            $customer->update([
                'serve_customer_id' => $serveCustomer['id'],
            ]);
        }

        DB::commit();
        return redirect()->route('master.customers.index')->with('success', 'Customer updated successfully.');
    } catch (\Exception $e) {
        DB::rollBack();
        dd($e);
        return redirect()->route('master.customers.index')->with('error', 'Failed to update customer.');
    }
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
