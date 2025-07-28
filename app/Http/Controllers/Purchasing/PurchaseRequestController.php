<?php

namespace App\Http\Controllers\Purchasing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchasing\PurchaseRequest;
use Barryvdh\DomPDF\Facade\Pdf; // if using barryvdh/laravel-dompdf



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

   public function destroy($id)
{
    $request = PurchaseRequest::findOrFail($id);
    $request->delete();

    return redirect()->route('purchasing.purchase-requests.index')->with('success', 'Purchase request deleted successfully.');
}

}
