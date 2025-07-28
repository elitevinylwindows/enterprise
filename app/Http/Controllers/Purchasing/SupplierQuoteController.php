<?php

namespace App\Http\Controllers\Purchasing;

use App\Http\Controllers\Controller;
use App\Models\Purchasing\SupplierQuote;
use Illuminate\Http\Request;

class SupplierQuoteController extends Controller
{
    public function index()
    {
        $supplierQuotes = SupplierQuote::with(['purchaseRequest', 'supplier'])->latest()->get();

        return view('purchasing.supplier_quotes.index', compact('supplierQuotes'));
    }
}
