<?php

namespace App\Http\Controllers;

use App\Models\Bom;
use Illuminate\Http\Request;
use App\Helper\BomImportHelper;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class BomController extends Controller
{
    public function index()
    {
        $boms = Bom::all();
        return view('inventory.bom.index', compact('boms'));
    }
public function show($id)
{
    $bom = Bom::findOrFail($id);
    return view('inventory.bom.show', compact('bom'));
}

    // Optional methods you may add later:
    public function create() {}
   public function edit(Bom $bom)
{
    return view('inventory.bom.edit', compact('bom'));
}



public function store(Request $request)
{
    $request->validate([
        'material_name' => 'required|string',
        'description'   => 'required|string',
        'unit'          => 'nullable|string',
        'vendor'        => 'nullable|string',
        'price'         => 'nullable|string',
        'sold_by'       => 'nullable|string',
        'lin_pcs'       => 'nullable|string',
    ]);

    $price = preg_replace('/[^\d.]/', '', $request->price); // strips $ and spaces

    Bom::create([
        'material_name' => $request->material_name,
        'description'   => $request->description,
        'unit'          => $request->unit,
        'vendor'        => $request->vendor,
        'price'         => $price, // sanitized
        'sold_by'       => $request->sold_by,
        'lin_pcs'       => $request->lin_pcs,
    ]);

    return redirect()->route('inventory.bom.index')->with('success', 'Material added.');
}

    
public function update(Request $request, bom $bom)
{
   
}

   

public function handleImports(Request $request)
{
    $file = $request->file('import_file');

    // Handle re-import from confirmation page
    if ($request->filled('import_file') && is_string($request->import_file)) {
        $tempPath = storage_path('app/temp_bom_import.xlsx');
        file_put_contents($tempPath, base64_decode($request->import_file));
        $file = new UploadedFile($tempPath, 'import.xlsx', null, null, true);
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
    $headerMap = BomImportHelper::getHeaderMap();

    $bomsToImport = [];
    $duplicateLicenses = [];

    foreach ($rows as $row) {
        $bomData = [];

        foreach ($headerRow as $index => $columnHeader) {
            $trimmedHeader = trim($columnHeader);
            $mappedField = $headerMap[$trimmedHeader] ?? null;

            if ($mappedField) {
                $value = trim($row[$index] ?? '');
                $bomData[$mappedField] = $value === '' ? null : $value;
            }
        }

        if (!empty($bomData['material_name'])) {
            $bomsToImport[] = $bomData;

            if (bom::where('material_name', $bomData['material_name'])->exists()) {
                $duplicateLicenses[] = $bomData['material_name'];
            }
        }
    }

    if (!$actionType && !empty($duplicateLicenses)) {
        return view('boms.confirm-import', [
            'duplicates' => $duplicateLicenses,
            'originalFile' => base64_encode(file_get_contents($file->getRealPath()))
        ]);
    }

    foreach ($bomsToImport as $data) {
        if (
            $actionType === 'skip' &&
            array_key_exists('material_name', $data) &&
            Bom::where('material_name', $data['material_name'])->exists()
        ) {
            continue;
        }

       // Clean price before saving
if (!empty($data['price'])) {
    $data['price'] = preg_replace('/[^\d.]/', '', $data['price']); // e.g. "$ 20.498" => "20.498"
}

Bom::updateOrCreate(
    ['material_name' => $data['material_name']],
    $data
);

    }

    return redirect()->route('inventory.bom.index')->with('success', 'boms imported successfully.');
}

}
