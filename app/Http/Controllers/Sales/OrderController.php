<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Mail\OrderMail;
use Illuminate\Http\Request;
use App\Models\Sales\Order;
use App\Models\Master\Customers\Customer;
use App\Models\Sales\Quote;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\JobPoolEnqueueService;
use App\Models\Sales\Invoice;


class OrderController extends Controller
{
    public function index(Request $request)
{
    $status = $request->get('status', 'all');

    $orders = Order::with('customer')
        ->when($status === 'deleted', function($query) {
            return $query->onlyTrashed();
        })
        ->latest()
        ->get();

    return view('sales.orders.index', compact('orders', 'status'));
}

    public function create()
    {
        $customers = Customer::pluck('customer_name', 'id');
        return view('sales.orders.create', compact('customers'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'quote_number' => 'required|string|max:20',
            'order_number' => 'required|string|max:20',
            'entry_date' => 'required|date',
            'delivery_date' => 'required|date|after_or_equal:entry_date',
            'status' => 'required|string',
            'notes' => 'nullable|string',
            'shipping' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();
            $quote = Quote::where('quote_number', $request->quote_number)->firstOrFail();
            $order = quoteToOrder($quote);
            $order->expected_delivery_date = $request->delivery_date;
            $order->shipping = $request->shipping;
            $order->notes = $request->notes;
            $order->status = $request->status;
            $order->save();

            sendOrderMail($order);
            DB::commit();

            return redirect()->route('sales.orders.index')->with('success', 'Order created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            // Log the error or handle it as needed
            Log::error('Order creation failed: ' . $e->getMessage());
            // Return an error response
            return redirect()->back()->withErrors(['error' => 'Failed to create order: ' . $e->getMessage()]);
        }

        return redirect()->route('sales.orders.index')->with('success', 'Order created successfully.');
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $customers = Customer::pluck('customer_name', 'id');
        $modificationsByDate = $order->items->where('is_modification', true)->groupBy(function ($mod) {
            return \Carbon\Carbon::parse($mod->modification_date)->format('Y-m-d h:i A');
        });
        return view('sales.orders.edit', compact('order', 'customers', 'modificationsByDate'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quote_number' => 'required|string|max:20',
            'order_number' => 'required|string|max:20',
            'entry_date' => 'required|date',
            'delivery_date' => 'required|date|after_or_equal:entry_date',
            'status' => 'required|string',
            'notes' => 'nullable|string',
            'shipping' => 'required|numeric',
        ]);
        try {
            DB::beginTransaction();
            $order = Order::findOrFail($id);
            $data = calculateTotal($order->quote, $request->shipping);
            $order->update($request->all());
            $order->update([
                "total" => $data['total'],
                "sub_total" => $data['sub_total'],
                "shipping" => $data['shipping'],
                "discount" => $data['total_discount'],
                "tax" => $data['tax'],
                "total" => $data['grand_total'],
            ]);

            DB::commit();
            return redirect()->route('sales.orders.index')->with('success', 'Order updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order update failed: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to update order: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->quote->update([
            'status' => 'saved',
        ]);
        $order->items()->delete();
        $order->invoice()->delete();
        $order->delete();

        return redirect()->route('sales.orders.index')->with('success', 'Order deleted successfully.');
    }

    public function getCustomer($customer_number)
    {
        $customer = DB::table('elitevw_master_customers')
            ->where('customer_number', $customer_number)
            ->first();

        if ($customer) {
            return response()->json(['customer_name' => $customer->customer_name]);
        } else {
            return response()->json(['error' => 'Customer not found'], 404);
        }
    }

    public function email($id)
    {
        try{
            $order = Order::findOrFail($id);
            $pdf = Pdf::loadView('sales.quotes.preview_pdf', ['order' => $order]);
            sendOrderMail($order);
            return response()->json(['success' => true, 'message' => 'Order emailed successfully.']);
        } catch (\Exception $e) {
            dd($e);
            Log::error("Failed to send order email: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to send order email: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);
        $modificationsByDate = $order->items->where('is_modification', true)->groupBy(function ($mod) {
            return \Carbon\Carbon::parse($mod->modification_date)->format('Y-m-d h:i A');
        });

        return view('sales.orders.show', compact('order', 'modificationsByDate'));
    }

    public function convertToInvoice($orderID)
    {
        try{
            DB::beginTransaction();
            $order = Order::findOrFail($orderID);
            $quote = $order->quote;
            $invoice = quoteToInvoice($quote, $order);
            DB::commit();
            return redirect()->route('sales.invoices.index')->with('success', 'Order converted to invoice successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to convert order to invoice: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to convert order to invoice: ' . $e->getMessage());
        }
    }


public function markRush($id, \App\Services\JobPoolEnqueueService $svc)
{
    $order   = \App\Models\Sales\Order::with(['quote', 'invoice'])->findOrFail($id);
    $quote   = $order->quote;
    $invoice = $order->invoice ?? \App\Models\Sales\Invoice::where('order_id', $order->id)->first();

    // If there's no invoice yet, create a pending one so payment can be taken now
    if (!$invoice) {
        $invoice = quoteToInvoice($quote, $order); // re-use your helper
        // Ensure status is pending so it won't block payment logic
        $invoice->update(['status' => 'pending']);
    }

    // Mark as rush (bypass 48h)
    $quote->update([
        'is_rush'        => true,
        'rushed_at'      => now(),
        'editable_until' => now(),
    ]);

    // Payment or Special?
    $hasPayment = $svc->paymentOnFile($invoice);
    $isSpecial  = (bool) $quote->is_special_customer;

    if ($hasPayment || $isSpecial) {
        $added = $svc->enqueueFromQuote($quote); // or enqueueQuoteItems(...)
        return back()->with('success', $added > 0
            ? "Order rushed and {$added} item(s) sent to Job Pool."
            : "Order rushed. No new items queued."
        );
    }

    // Build the modal payload
    $payload = [
        'message'     => 'Cannot rush: no deposit on file.',
        'payment_url' => route('sales.invoices.payment', $invoice->id),   // GET → loads your modal
        'special_url' => route('sales.invoices.special', $invoice->id),   // POST
        'order_id'    => $order->id,
        'invoice_id'  => $invoice->id,
    ];

    return back()
        ->with('rush_block', $payload)
        ->with('error', 'Cannot rush: no deposit found. Take payment or mark as Special Customer.');
}


public function restore($id)
{
    Order::withTrashed()->findOrFail($id)->restore();
    return redirect()->route('sales.orders.index', ['status' => 'deleted'])
        ->with('success', 'Order restored successfully');
}

public function forceDelete($id)
{
    Order::withTrashed()->findOrFail($id)->forceDelete();
    return redirect()->route('sales.orders.index', ['status' => 'deleted'])
        ->with('success', 'Order permanently deleted');
}


public function pdf(\App\Models\Order $order)
{
    $pdfPath = $order->pdf_path; // or rebuild it the same way you did in the mail
    abort_unless($pdfPath && Storage::disk('public')->exists($pdfPath), 404);

    return response()->file(
        Storage::disk('public')->path($pdfPath),
        ['Content-Type' => 'application/pdf']
    );
}

}
