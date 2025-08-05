<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Purchasing\PurchaseRequest;
use App\Models\Purchasing\PurchaseRequestItem;
use App\Models\Purchasing\PurchaseOrder;
use App\Models\Purchasing\PurchaseOrderItem;
use App\Models\SupplierPurchaseRequestQuote;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\Inventory\SupplierQuote;

class PurchaseRequestController extends Controller
{

public function secureView($token)
{
    try {
        $decryptedId = Crypt::decryptString($token);
        $request = PurchaseRequest::with(['items.product', 'supplier'])->findOrFail($decryptedId);
    } catch (\Exception $e) {
        abort(403, 'Invalid or expired token.');
    }

    return view('supplier.purchase_requests.view', compact('request'));
}





public function submitResponse(Request $request, $id)
{
    $request->validate([
        'response_action' => 'required|in:approve,modify_and_approve,cancel',
        'quote_file' => 'required|file|mimes:pdf|max:5120',
        'prices' => 'nullable|array',
        'prices.*' => 'nullable|numeric|min:0',
    ]);

    $pr = PurchaseRequest::with('items')->findOrFail($id);

    DB::beginTransaction();
    try {
        $path = $request->file('quote_file')->store('supplier_pr_quotes');

        // Recalculate total
        $total = 0;
        if ($request->response_action === 'modify_and_approve' && is_array($request->prices)) {
            foreach ($pr->items as $item) {
                if (isset($request->prices[$item->id])) {
                    $item->unit_price = $request->prices[$item->id];
                    $item->save();
                }
                $total += $item->quantity * $item->unit_price;
            }
        } else {
            foreach ($pr->items as $item) {
                $total += $item->quantity * $item->unit_price;
            }
        }

        // Save supplier quote record
        SupplierQuote::create([
            'quote_number' => 'SQ' . strtoupper(Str::random(6)),
            'supplier_id' => $pr->supplier_id,
            'purchase_request_id' => $pr->id,
            'quote_date' => now(),
            'valid_until' => now()->addDays(30),
            'status' => $request->response_action,
            'file_path' => $path,
            'total_amount' => $total,
        ]);

        if ($request->response_action === 'cancel') {
            $pr->status = 'cancelled';
            $pr->save();
            DB::commit();
            return redirect()->route('supplier.purchase_request.view', ['token' => encrypt($pr->id)])
                ->with('success', 'Request cancelled successfully.');
        }

        // Auto-create PO
        $po = PurchaseOrder::create([
            'supplier_id' => $pr->supplier_id,
            'purchase_request_id' => $pr->id,
            'order_number' => 'PO' . strtoupper(Str::random(6)),
            'status' => 'created',
            'date' => now(),
        ]);

        foreach ($pr->items as $item) {
            PurchaseOrderItem::create([
                'purchase_order_id' => $po->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
            ]);
        }

        $pr->status = 'converted';
        $pr->save();

        DB::commit();
        return redirect()->route('supplier.purchase_request.view', ['token' => encrypt($pr->id)])
            ->with('success', 'Response submitted successfully.');
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Supplier quote submission failed: ' . $e->getMessage());
        return back()->with('error', 'Something went wrong.');
    }
}
}