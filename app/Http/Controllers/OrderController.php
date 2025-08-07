<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Helper\OrderImportHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    private array $integerFields = [
        'manual_lock', 'cw', 'units', 'number_of_fields', 'tax',
        'credit_limit_block', 'waiting_for_change_order'
    ];

    private array $booleanFields = [
        'invoice_printed', 'archived', 'delivery_note_exists', 'delivery_note_printed', 'invoice_exists',
        'credit_note_exists', 'internal_invoice_exists', 'manual_lock', 'order_complete', 'outside_sales',
        'import_assignment', 'dispatch_planned', 'canceled', 'completed', 'complete_receipt',
        'deposit_invoice_exists', 'external_manufacturing'
    ];

   public function index(Request $request)
{
    $query = \App\Models\Order::query(); // Ensure correct model

    if ($search = $request->input('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('order_number', 'like', "%$search%")
                ->orWhere('customer_name', 'like', "%$search%")
                ->orWhere('short_name', 'like', "%$search%")
                ->orWhere('project_number', 'like', "%$search%")
                ->orWhere('comment', 'like', "%$search%")
                ->orWhere('commission', 'like', "%$search%")
                ->orWhere('internal_order_number', 'like', "%$search%")
                ->orWhere('customer', 'like', "%$search%")
                ->orWhere('city', 'like', "%$search%");
        });
    }

    $orders = $query->paginate(50000000000); // Pagination works correctly if data is available

    return view('orders.index', compact('orders'));
}

    public function handleImports(Request $request)
    {
        $file = $request->file('import_file');

        // Handle re-import from confirmation page
        if ($request->filled('import_file') && is_string($request->import_file)) {
            $tempPath = storage_path('app/temp_import.xlsx');
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
        $headerMap = OrderImportHelper::getHeaderMap();

        $ordersToImport = [];
        $duplicateOrderNumbers = [];

        foreach ($rows as $row) {
            $orderData = [];

            foreach ($headerRow as $index => $columnHeader) {
                $mappedField = $headerMap[trim($columnHeader)] ?? null;

                if ($mappedField && isset($row[$index])) {
                    $value = trim($row[$index]);

                    // Format date
                    if (in_array($mappedField, ['entry_date', 'required_date', 'delivery_date', 'arrival_date', 'required_date_cw', 'entry_date_original', 'print_date', 'validity_date', 'purchase_order_date'])) {
                        $value = $this->formatDate($value);
                    }
                    // Set integer fields
                    elseif (in_array($mappedField, $this->integerFields) && $value === '') {
                        $value = 0;
                    }
                    // Set boolean fields
                    elseif (in_array($mappedField, $this->booleanFields) && $value === '') {
                        $value = 0;
                    }

                    $orderData[$mappedField] = $value;
                }
            }

            if (!empty($orderData['order_number'])) {
                if (Order::where('order_number', $orderData['order_number'])->exists()) {
                    $duplicateOrderNumbers[] = $orderData['order_number'];
                }
                $ordersToImport[] = $orderData;
            }
        }

        // Confirmation View if not choosing action yet
        if (!$actionType && !empty($duplicateOrderNumbers)) {
            return view('orders.confirm-import', [
                'duplicates' => $duplicateOrderNumbers,
                'originalFile' => base64_encode(file_get_contents($file->getRealPath()))
            ]);
        }

        // Insert/Update
        foreach ($ordersToImport as $data) {
            if ($actionType === 'skip' && Order::where('order_number', $data['order_number'])->exists()) {
                continue;
            }

            Order::updateOrCreate(
                ['order_number' => $data['order_number']],
                $data
            );
        }

        return redirect()->route('orders.index')->with('success', 'Orders imported successfully.');
    }

    private function formatDate($value)
    {
        $value = trim($value);
        if (!$value) return null;

        try {
            $date = \DateTime::createFromFormat('m/d/Y', $value);
            return $date ? $date->format('Y-m-d') : null;
        } catch (\Exception $e) {
            return null;
        }
    }

}
