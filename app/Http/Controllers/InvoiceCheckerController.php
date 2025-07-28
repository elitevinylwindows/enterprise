<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery;

class InvoiceCheckerController extends Controller
{
    public function index()
    {
        $invoices = Delivery::select(
            'order_number',
            'customer_name',
            'customer',
            'payment_status',
            'payment_method',
            'payment_amount',
            'cancel_note',
            'delivery_note',
            'status'
        )->orderByDesc('updated_at')->get();

        return view('invoice_checker.index', compact('invoices'));
    }
}
