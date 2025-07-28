<?php

namespace App\Http\Controllers\Master\Prices;

use Illuminate\Http\Request;
use App\Models\Master\Prices\ProductPrices;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Helper\PricesImportHelper;
use Illuminate\Support\Facades\Schema;

class ProductPricesController extends \App\Http\Controllers\Controller
{
    public function index(Request $request)
    {
        $query = ProductPrices::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('product_id', 'like', "%$search%")
                    ->orWhere('product_class', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
                    ->orWhere('retrofit', 'like', "%$search%")
                    ->orWhere('clr', 'like', "%$search%")
                    ->orWhere('feat1', 'like', "%$search%")
                    ->orWhere('feat2', 'like', "%$search%")
                    ->orWhere('feat3', 'like', "%$search%")
                    ->orWhere('price_piece', 'like', "%$search%")
                    ->orWhere('price_box', 'like', "%$search%")
                    ->orWhere('price_sq_ft', 'like', "%$search%");
            });
        }

        $prices = $query->paginate(100000000000);

        return view('master.prices.productprices.index', compact('prices'));
    }

    public function handleImports(Request $request)
    {
        $file = $request->file('import_file');

        if (!$file || !$file->isValid()) {
            return back()->with('error', 'The uploaded file is invalid.');
        }

        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        if (empty($rows)) {
            return back()->with('error', 'The uploaded file is empty or incorrectly formatted.');
        }

        $headerRow = array_shift($rows);
        $headerMap = PricesImportHelper::getHeaderMap();
        $validColumns = Schema::getColumnListing((new ProductPrices)->getTable());

        // Define known decimal fields
        $decimalFields = [
    'retrofit', 'nailon', 'block', 'clr', 'le3',
        'le3_clr', 'clr_clr', 'le3_lam', 'le3_clr_le3', 'clr_temp', 'onele3_1clrtemp', 'twole3_1clrtemp', 'lam_temp',
        'clt_clt', 'let_let_let', 'let_clt_let', 'let_lam_let', 'let_clt', 'obs', 'gery', 'rain', 'temp', 'clr_lam',
        'color_multi', 'base_multi', 'feat1', 'feat2', 'feat3', 'sta_grd', 'tpi', 'tpo', 'acid_etch', 'acid_edge',
        'solar_cool', 'solar_cool_g', 'sales_factor', 'total_cost', 'cost_ft', 'cost_pc', 'cost', 'mark_up', 'rate',
        'm_cost', 'calculated_cost', 'cost_inch', 'unit_box', 'price_box', 'price_piece', 'box_weight', 'ft_box',
        'inch_box', 'price_inch', 'vent', 'xfix', 'fix', 'grid', 'lam_im_gx', 'two_panel_frame', 'three_panel_frame',
        'four_panel_frame', 'panel', 'price_sq_ft', 'stf', 'labor_sta', 'labor_field', 'profit',
        'purchase_price', 'markup_percentage', 'purchase_by_piece', 'purchase_by_bnd_99', 'purchase_by_bnd_54',
        'purchase_by_bnd_70', 'purchase_by_bnd_63', 'purchase_by_bnd_77', 'purchase_by_bnd_49', 'purchase_by_bnd_42',
        'purchase_by_bnd_396', 'purchase_by_bnd_510', 'purchase_by_bnd_341', 'purchase_by_bnd_81',
        'purchase_by_bnd_72', 'purchase_by_bnd_90'
];


        $recordsToImport = [];

        foreach ($rows as $row) {
            $record = [];

            foreach ($headerRow as $index => $columnHeader) {
                $mappedField = $headerMap[trim($columnHeader)] ?? null;

                if ($mappedField && isset($row[$index]) && in_array($mappedField, $validColumns)) {
                    $record[$mappedField] = trim($row[$index]);
                }
            }

            if (!empty($record['product_id'])) {
                // Default schema_id to null if not set
                $record['schema_id'] = $record['schema_id'] ?? null;

                // Convert decimal fields: empty string -> null, otherwise cast to float
                foreach ($decimalFields as $field) {
                    if (array_key_exists($field, $record)) {
                        $record[$field] = is_numeric($record[$field]) ? (float) $record[$field] : null;
                    }
                }

                $recordsToImport[] = $record;
            }
        }

        foreach ($recordsToImport as $data) {
            ProductPrices::updateOrCreate(
                ['product_id' => $data['product_id'], 'schema_id' => $data['schema_id']],
                $data
            );
        }

        return redirect()->route('prices.productprices.index')->with('success', 'Product Prices imported successfully.');
    }
}
