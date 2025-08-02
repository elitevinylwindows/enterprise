<?php

namespace App\Http\Controllers;

use App\Models\Purchasing\PurchaseRequest;
use App\Models\Purchasing\PurchaseRequestItem;
use Illuminate\Support\Facades\Crypt;

class ActionController extends Controller
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
}    