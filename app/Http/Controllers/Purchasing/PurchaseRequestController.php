<?php

namespace App\Http\Controllers\Purchasing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\Purchasing\SupplierQuote;
use App\Mail\PurchaseRequestToSupplierMail;
use App\Models\Purchasing\PurchaseRequest;
use Barryvdh\DomPDF\Facade\Pdf; 




class PurchaseRequestController extends Controller
{
public function index()
    {
        $purchaseRequests = PurchaseRequest::all();
        return view('purchasing.purchase_requests.index', compact('purchaseRequests'));
    }   
    public function create() { return view('purchasing.purchase_requests.create'); }
    public function store(Request $request) {}
    public function edit($id) { return view('purchasing.purchase_requests.edit'); }
    public function update(Request $request, $id) {}
    
    public function show($id)
{
    $request = PurchaseRequest::with('items.product')->findOrFail($id);
    return view('purchasing.purchase_requests.show', compact('request'));
}

public function download($id)
{
    $request = PurchaseRequest::with('items.product', 'supplier')->findOrFail($id);

    $pdf = Pdf::loadView('purchasing.purchase_requests.pdf', compact('request'));

    return $pdf->download('PurchaseRequest-' . $request->purchase_request_id . '.pdf');
}


public function sendToSupplier($id)
{
    $request = PurchaseRequest::with('items.product')->findOrFail($id);
    $product = $request->items->first()->product ?? null;
    $supplier = $product?->supplier;

    if (!$supplier || !$supplier->email) {
        return redirect()->back()->with('error', 'Supplier email not found.');
    }

   $supplierQuote = SupplierQuote::where([
    'purchase_request_id' => $request->id,
    'supplier_id' => $supplier->id,
])->first();

if (!$supplierQuote) {
    $supplierQuote = SupplierQuote::create([
        'purchase_request_id' => $request->id,
        'supplier_id' => $supplier->id,
        'quote_number' => 'SQ-' . strtoupper(Str::random(6)),
        'quote_date' => now(),
        'secure_token' => Str::uuid(),
        'status' => 'pending',
    ]);
} elseif (!$supplierQuote->secure_token) {
    $supplierQuote->secure_token = Str::uuid();
    $supplierQuote->save();
}


    Mail::to($supplier->email)->send(new PurchaseRequestToSupplierMail($supplierQuote, $supplier->name));

    return redirect()->back()->with('success', 'Email sent to supplier.');
}

public function secureView($token)
{
    $quote = \App\Models\Purchasing\SupplierQuote::where('secure_token', $token)
        ->with(['purchaseRequest.items.product', 'supplier'])
        ->firstOrFail();

    return view('purchasing.supplier_quotes.secure_view', compact('quote'));
}

   public function destroy($id)
{
    $request = PurchaseRequest::findOrFail($id);
    $request->delete();

    return redirect()->route('purchasing.purchase-requests.index')->with('success', 'Purchase request deleted successfully.');
}

}
