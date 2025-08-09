<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Master\Customers\Customer;
use App\Models\Sales\Invoice;
use App\Models\Sales\InvoicePayment;
use App\Models\Sales\Order;
use App\Models\Sales\Quote;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_invoices' => Invoice::count(),
            'total_orders' => Order::count(),
            'total_quotes' => Quote::count(),
            'total_customers' => Customer::count(),
        ];

        $recentQuotes = Quote::latest()->take(5)->get();
        $recentOrders = Order::latest()->take(5)->get();
        return view('sales.dashboard.index', compact('stats', 'recentQuotes', 'recentOrders'));
    }
}
