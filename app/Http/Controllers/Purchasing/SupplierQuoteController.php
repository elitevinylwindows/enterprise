<?php

namespace App\Http\Controllers\Purchasing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Purchasing\PurchaseRequest;
use App\Models\Purchasing\PurchaseOrder;
use App\Models\Purchasing\SupplierQuote;

class SupplierQuoteController extends Controller
{
    public function index()
    {
        $supplierQuotes = SupplierQuote::with(['purchaseRequest', 'supplier'])->latest()->get();

        return view('purchasing.supplier_quotes.index', compact('supplierQuotes'));
    }



public function secureView($token)
{
    $quote = SupplierQuote::where('secure_token', $token)->with('purchaseRequest', 'purchaseRequest.items')->firstOrFail();
    return view('purchasing.supplier_quotes.supplier_view', compact('quote'));
}

public function respond(Request $request)
{
    $request->validate([
        'quote_id' => 'required|exists:elitevw_inventory_supplier_quotes,id',
        'response_action' => 'required|in:approve,modify,cancel',
        'attachment' => 'nullable|file|mimes:pdf,doc,docx',
        'prices' => 'nullable|array'
    ]);

    $quote = SupplierQuote::findOrFail($request->quote_id);

    if ($request->response_action === 'cancel') {
        $quote->status = 'cancelled';
        $quote->save();
        return view('purchasing.supplier_quotes.success')->with('message', 'You have cancelled the request.');
    }

    if ($request->hasFile('attachment')) {
        $path = $request->file('attachment')->store('supplier_quotes');
        $quote->attachment = $path;
    }

    if ($request->response_action === 'modify') {
        foreach ($request->prices as $itemId => $price) {
            DB::table('elitevw_purchasing_purchase_request_items')
                ->where('id', $itemId)
                ->update(['unit_price' => $price]);
        }
    }

    $quote->status = 'approved';
    $quote->save();

    // Auto-create purchase order
    PurchaseOrder::create([
        'supplier_id' => $quote->supplier_id,
        'purchase_request_id' => $quote->purchase_request_id,
        'status' => 'open',
        'order_date' => now(),
        'tracking_number' => null,
    ]);

    return view('purchasing.supplier_quotes.success')->with('message', 'Your response has been recorded and a purchase order has been created.');
}


public function approve(Request $request, $id)
{
    $request->validate(['quote_file' => 'nullable|file|mimes:pdf,jpg,png']);

    $quote = new SupplierQuote();
    $quote->supplier_id = $request->supplier_id;
    $quote->quote_number = 'SQ' . rand(10000, 99999);
    $quote->purchase_request_id = $id;
    $quote->quote_date = now();
    $quote->status = 'approved';

    if ($request->hasFile('quote_file')) {
        $quote->attachment = $request->file('quote_file')->store('supplier_quotes');
    }

    $quote->save();

    // 🔄 Optional: generate purchase order here automatically
    PurchaseOrder::create([
        'supplier_id' => $quote->supplier_id,
        'purchase_request_id' => $id,
        'order_number' => 'PO' . rand(10000, 99999),
        'status' => 'pending'
    ]);

    return view('purchasing.supplier_quotes.success', ['message' => 'Quote approved.']);
}


public function modifyAndApprove(Request $request, $id)
{
    $quote = SupplierQuote::with('purchaseRequest.items')->findOrFail($id);

    $request->validate([
        'price.*' => 'required|numeric|min:0',
        'quote_file' => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:2048',
    ]);

    DB::beginTransaction();
    try {
        foreach ($quote->purchaseRequest->items as $index => $item) {
            if (isset($request->price[$item->id])) {
                $item->price = $request->price[$item->id];
                $item->total = $item->qty * $item->price;
                $item->save();
            }
        }

        if ($request->hasFile('quote_file')) {
            $path = $request->file('quote_file')->store('supplier_quotes', 'public');
            $quote->attachment = $path;
        }

        $quote->status = 'approved';
        $quote->save();

        // ✅ Also create the PO automatically
        PurchaseOrder::create([
            'purchase_request_id' => $quote->purchase_request_id,
            'supplier_id' => $quote->supplier_id,
            'status' => 'pending',
            'order_date' => now(),
            'attachment' => $quote->attachment,
        ]);

        DB::commit();

        return redirect()->route('supplier.quote.view', $quote->secure_token)
            ->with('success', 'Quote modified and approved successfully.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Failed to process: ' . $e->getMessage());
    }
}

   public function cancel($id)
{
    $pr = PurchaseRequest::findOrFail($id);
    $pr->status = 'cancelled';
    $pr->save();

    return view('purchasing.supplier_quotes.success', ['message' => 'Quote cancelled.']);
}
 
}
