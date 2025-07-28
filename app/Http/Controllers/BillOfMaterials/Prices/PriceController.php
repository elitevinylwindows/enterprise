<?php

namespace App\Http\Controllers\BillOfMaterials\Prices;

use App\Http\Controllers\Controller;
use App\Models\BillOfMaterials\Prices\Price;
use Illuminate\Http\Request;
use App\Helper\PriceImportHelper;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PriceController extends Controller
{
    public function index()
{
    $prices = Price::latest()->paginate(25); // change 25 to whatever per-page you want
    return view('bill_of_material.prices.index', compact('prices'));
}


    public function show($id)
    {
        $price = Price::findOrFail($id);
        return view('price.show', compact('price'));
    }

    public function create() {}

    public function edit($id)
{
    $price = Price::findOrFail($id);
    return view('bill_of_material.prices.edit', compact('price'));
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

    $cleanPrice = floatval(preg_replace('/[^\d.]/', '', $request->price));

    $lin_pcs = Price::calculateLinPcs(
        $cleanPrice,
        $request->description,
        $request->unit,
        $request->sold_by
    );

    Price::create([
        'material_name' => $request->material_name,
        'description'   => $request->description,
        'unit'          => $request->unit,
        'vendor'        => $request->vendor,
        'price'         => $cleanPrice,
        'sold_by'       => $request->sold_by,
        'lin_pcs'       => $lin_pcs,
    ]);

    return redirect()->route('prices.index')->with('success', 'Material added.');
}


   public function update(Request $request, Price $price)
{
    $request->validate([
        'material_name' => 'required|string|max:255',
        'description' => 'required|string',
        'unit' => 'nullable|string',
        'vendor' => 'nullable|string',
        'price' => 'nullable|numeric',
        'sold_by' => 'nullable|string',
        'lin_pcs' => 'nullable|string',
    ]);

    $price->update($request->all());

    return redirect()->route('prices.index')->with('success', 'Material updated successfully!');
}

    private function extractCountFromUnit($unit)
{
    if (!$unit) return 0;

    if (preg_match('/(\d+)\s*pcs?(\/(box|tube|roll|spool|bnd|bundle))?/i', $unit, $matches)) {
        return (int) $matches[1];
    }

    return 0;
}

private function getDefaultCountIfMissing($soldBy)
{
    $soldBy = strtolower(trim($soldBy));

    return in_array($soldBy, ['by pcs', 'by tube', 'by box', 'by bnd', 'by roll', 'by spool']) ? 1 : 0;
}

    private function extractLengthFromDescription($desc)
    {
        if (preg_match_all("/(\d+)'/", $desc, $matches) && count($matches[1]) > 0) {
            return (int) end($matches[1]) * 12;
        }

        return 0;
    }

    public function handleImports(Request $request)
    {
        $file = $request->file('import_file');

        if ($request->filled('import_file') && is_string($request->import_file)) {
            $tempPath = storage_path('app/temp_price_import.xlsx');
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
        $headerMap = PriceImportHelper::getHeaderMap();

        $pricesToImport = [];
        $duplicateLicenses = [];

        foreach ($rows as $row) {
            $priceData = [];

            foreach ($headerRow as $index => $columnHeader) {
                $trimmedHeader = trim($columnHeader);
                $mappedField = $headerMap[$trimmedHeader] ?? null;

                if ($mappedField) {
                    $value = trim($row[$index] ?? '');
                    $priceData[$mappedField] = $value === '' ? null : $value;
                }
            }

            if (!empty($priceData['material_name'])) {
                $pricesToImport[] = $priceData;

                if (Price::where('material_name', $priceData['material_name'])->exists()) {
                    $duplicateLicenses[] = $priceData['material_name'];
                }
            }
        }

        if (!$actionType && !empty($duplicateLicenses)) {
            return view('prices.confirm-import', [
                'duplicates' => $duplicateLicenses,
                'originalFile' => base64_encode(file_get_contents($file->getRealPath()))
            ]);
        }

        foreach ($pricesToImport as $data) {
    if (
        $actionType === 'skip' &&
        array_key_exists('material_name', $data) &&
        Price::where('material_name', $data['material_name'])->exists()
    ) {
        continue;
    }

    // Clean and calculate
    if (!empty($data['price'])) {
        $priceValue = floatval(preg_replace('/[^\d.]/', '', $data['price']));
        $count = $this->extractCountFromUnit($data['unit'] ?? '');
        $length = $this->extractLengthFromDescription($data['description'] ?? '');

        if ($count === 0) {
            $count = $this->getDefaultCountIfMissing($data['sold_by'] ?? '');
        }

        if ($count > 0 && $length > 0) {
            $data['lin_pcs'] = round($priceValue / ($count * $length), 5);
        } else {
            $data['lin_pcs'] = null;
        }

        $data['price'] = $priceValue;
    }

    Price::updateOrCreate(
        ['material_name' => $data['material_name']],
        $data
    );
}

        return redirect()->route('prices.index')->with('success', 'Prices imported successfully.');
    }
}
