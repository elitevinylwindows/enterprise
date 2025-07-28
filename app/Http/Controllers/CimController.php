<?php

namespace App\Http\Controllers;

use App\Models\Cim;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Log;
use App\Helper\CimImportHelper;




class CimController extends Controller
{
    
    
    private array $integerFields = ['width', 'height'];


public function index(Request $request)
{
    
    
    $query = Cim::query();

    if ($search = $request->input('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('order_number', 'like', "%$search%")
                ->orWhere('customer_name', 'like', "%$search%")
                ->orWhere('short_name', 'like', "%$search%")
                ->orWhere('project_number', 'like', "%$search%")
                ->orWhere('comment', 'like', "%$search%")
                ->orWhere('internal_order_number', 'like', "%$search%")
                ->orWhere('customer', 'like', "%$search%")
                ->orWhere('city', 'like', "%$search%");
        });
    }

    $cims = $query->paginate(500000000000000);

    return view('cims.index', compact('cims'));
}



public function handleImports(Request $request)
{
    $file = $request->file('import_file');

    // Handle re-import from confirmation page
    if ($request->filled('import_file') && is_string($request->import_file)) {
        $tempPath = storage_path('app/temp_cim_import.xlsx');
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
    $headerMap = \App\Helper\CimImportHelper::getHeaderMap();

    $cimsToImport = [];
    $duplicateProductionBarcodes = [];

    foreach ($rows as $row) {
        $cimData = [];

        foreach ($headerRow as $index => $columnHeader) {
            $trimmedHeader = trim($columnHeader);
            $mappedField = $headerMap[$trimmedHeader] ?? null;

            if ($mappedField) {
                $value = trim($row[$index] ?? '');
                $cimData[$mappedField] = $value === '' ? null : $value;
            }
        }

        // ✅ Skip if production_barcode is missing or empty
        if (!empty($cimData['production_barcode'])) {
            $cimsToImport[] = $cimData;

            if (\App\Models\Cim::where('production_barcode', $cimData['production_barcode'])->exists()) {
                $duplicateProductionBarcodes[] = $cimData['production_barcode'];
            }
        }
    }

    if (!$actionType && !empty($duplicateProductionBarcodes)) {
        return view('cims.confirm-import', [
            'duplicates' => $duplicateProductionBarcodes,
            'originalFile' => base64_encode(file_get_contents($file->getRealPath()))
        ]);
    }

    foreach ($cimsToImport as $data) {
        if (
            $actionType === 'skip' &&
            array_key_exists('production_barcode', $data) &&
            \App\Models\Cim::where('production_barcode', $data['production_barcode'])->exists()
        ) {
            continue;
        }

        \App\Models\Cim::updateOrCreate(
            ['production_barcode' => $data['production_barcode']],
            $data
        );
    }

    return redirect()->route('cims.index')->with('success', 'CIM items imported successfully.');
}

    
protected function updateDeliveryCartsField($orderNumber)
{
    $cartBarcodes = \App\Models\Cim::where('order_number', $orderNumber)
        ->whereNotNull('cart_barcode')
        ->pluck('cart_barcode')
        ->unique()
        ->toArray();

    $cartList = implode('; ', $cartBarcodes);

    \App\Models\Delivery::where('order_number', $orderNumber)->update([
        'carts' => $cartList,
    ]);
}

}

