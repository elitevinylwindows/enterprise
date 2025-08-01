<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales\Quote;
use App\Models\Master\Series\Series;
use App\Models\Master\Series\SeriesType;
use App\Models\Master\Customers\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Sales\QuoteItem;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;

class QuoteController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        $quotes = Quote::query();

        if ($status !== 'all') {
            $quotes->where('status', $status);
        }

        $quotes = $quotes->latest()->get();

        return view('sales.quotes.index', compact('quotes', 'status'));
    }



    public function create()
    {
        // Clear session unless returning
        if (!session()->has('returning_from_details')) {
            session()->forget(['customer_number', 'customer_name', 'quote_number']);
        }
        session()->forget('returning_from_details');

        // Predict next quote number (NOT saved yet)
        $lastQuote = \App\Models\Sales\Quote::latest('id')->first();
        $nextNumber = $lastQuote ? $lastQuote->id + 1 : 1;
        $previewQuoteNumber = 'Q' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        // Series dropdown
        $seriesList = Series::pluck('series', 'id');

        // All config thumbnails grouped by category
        $allConfigurations = Series::with(['configurations' => function ($query) {
            $query->select('id', 'series_id', 'series_type', 'category', 'image');
        }])->get()->mapWithKeys(function ($series) {
            return [$series->id => $series->configurations->map(function ($conf) use ($series) {
                return [
                    'name' => $conf->series_type,
                    'category' => $conf->category,
                    'image' => $conf->image,
                    'series' => $series->name,
                ];
            })];
        })->toArray();

        return view('sales.quotes.create', [
            'quoteNumber' => $previewQuoteNumber,
            'customerNumber' => session('customer_number'),
            'customerName' => session('customer_name'),
            'entryDate' => now()->toDateString(),
            'expectedDelivery' => now()->addDays(14)->toDateString(),
            'validUntil' => now()->addDays(30)->toDateString(),
            'enteredBy' => auth()->user()?->name ?? 'System',
            'seriesList' => $seriesList,
            'allConfigurations' => $allConfigurations,
        ]);
    }

    public function checkPrice(Request $request)
    {
        $request->validate([
            'series_id' => 'required',
            'series_type' => 'required',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
        ]);

        // The 'series_type' column is a JSON array, so we use whereJsonContains for matching
        $seriesType = DB::table('elitevw_master_series_types')
            ->where('series_id', $request->series_id)
            ->whereJsonContains('series_type', $request->series_type)
            ->first();

        $price = DB::table('elitevw_master_price_price_matrices')
            ->where('series_id', $request->series_id)
            ->where('series_type_id', $seriesType->id)
            ->where('width', $request->width)
            ->where('height', $request->height)
            ->value('price');

        \Log::info('Checking price matrix', [
            'series_id' => $request->series_id,
            'series_type' => $request->series_type,
            'width' => $request->width,
            'height' => $request->height,
            'price_found' => $price
        ]);

        return response()->json(['price' => $price]);
    }


    public function storeItem(Request $request, $id)
    {
        try {
            $request->validate([
                'description' => 'required|string',
                'series_id' => 'required|integer|exists:elitevw_master_series,id',
                'series_type' => 'required|string',
                'item_id' => ' nullable|integer',
                'width' => 'required|numeric',
                'height' => 'required|numeric',
                'glass' => 'required|string',
                'grid' => 'required|string',
                'qty' => 'required|numeric',
                'price' => 'required|numeric',
                'total' => 'required|numeric',
                'item_comment' => 'required|string',
                'internal_note' => 'required|string',
                'color_config' => 'required|numeric',
                'color_exterior' => 'required|numeric',
                'color_interior' => 'required|numeric',
                'frame_type' => 'required|string',
                'fin_type' => 'required|string',
                'glass_type' => 'required|string',
                'spacer' => 'required|string',
                'tempered' => 'required|string',
                'specialty_glass' => 'required|string',
                'grid_pattern' => 'required|string',
                'grid_profile' => 'required|string',
                'retrofit_bottom_only' => 'required|boolean',
                'no_logo_lock' => 'required|boolean',
                'double_lock' => 'required|boolean',
                'custom_lock_position' => 'required|boolean',
                'custom_vent_latch' => 'required|boolean',
                'knocked_down' => 'required|boolean',
            ]);
            // Check if item already exists
            if (isset($validated['item_id']) && $validated['item_id']) {

                $existingItem = QuoteItem::where('id', $validated['item_id'])->first();

                if ($existingItem) {
                    // Update existing item
                    $existingItem->update([
                        'description' => $request->description,
                        'width' => $request->width,
                        'height' => $request->height,
                        'glass' => $request->glass,
                        'grid' => $request->grid,
                        'qty' => $request->qty,
                        'price' => $request->price,
                        'total' => $request->total,
                        'item_comment' => $request->item_comment,
                        'internal_note' => $request->internal_note,
                        'color_config' => $request->color_config,
                        'color_exterior' => $request->color_exterior,
                        'color_interior' => $request->color_interior,
                        'frame_type' => $request->frame_type,
                        'fin_type' => $request->fin_type,
                        'glass_type' => $request->glass_type,
                        'spacer' => $request->spacer,
                        'tempered' => $request->tempered,
                        'specialty_glass' => $request->specialty_glass,
                        'grid_pattern' => $request->grid_pattern,
                        'grid_profile' => $request->grid_profile,
                        'retrofit_bottom_only' => $request->boolean('retrofit_bottom_only'),
                        'no_logo_lock' => $request->boolean('no_logo_lock'),
                        'double_lock' => $request->boolean('double_lock'),
                        'custom_lock_position' => $request->boolean('custom_lock_position'),
                        'custom_vent_latch' => $request->boolean('custom_vent_latch'),
                        'knocked_down' => $request->boolean('knocked_down'),
                        'checked_count' => collect([
                            $request->retrofit_bottom_only,
                            $request->no_logo_lock,
                            $request->double_lock,
                            $request->custom_lock_position,
                            $request->custom_vent_latch
                        ])->filter()->count(),
                    ]);
                }
                $item = $existingItem;
            } else {

                $item = QuoteItem::create([
                    'quote_id' => $id,
                    'series_id' => $request->series_id,
                    'series_type' => $request->series_type,
                    'description' => $request->description,
                    'width' => $request->width,
                    'height' => $request->height,
                    'glass' => $request->glass,
                    'grid' => $request->grid,
                    'qty' => $request->qty,
                    'price' => $request->price,
                    'total' => $request->total,
                    'item_comment' => $request->item_comment,
                    'internal_note' => $request->internal_note,
                    'color_config' => $request->color_config,
                    'color_exterior' => $request->color_exterior,
                    'color_interior' => $request->color_interior,
                    'frame_type' => $request->frame_type,
                    'fin_type' => $request->fin_type,
                    'glass_type' => $request->glass_type,
                    'spacer' => $request->spacer,
                    'tempered' => $request->tempered,
                    'specialty_glass' => $request->specialty_glass,
                    'grid_pattern' => $request->grid_pattern,
                    'grid_profile' => $request->grid_profile,
                    'retrofit_bottom_only' => $request->boolean('retrofit_bottom_only'),
                    'no_logo_lock' => $request->boolean('no_logo_lock'),
                    'double_lock' => $request->boolean('double_lock'),
                    'custom_lock_position' => $request->boolean('custom_lock_position'),
                    'custom_vent_latch' => $request->boolean('custom_vent_latch'),
                    'knocked_down' => $request->boolean('knocked_down'),
                    'checked_count' => collect([
                        $request->retrofit_bottom_only,
                        $request->no_logo_lock,
                        $request->double_lock,
                        $request->custom_lock_position,
                        $request->custom_vent_latch
                    ])->filter()->count(),
                ]);
            }

            return response()->json([
                'success' => true,
                'item_id' => $item->id
            ]);
        } catch (\Exception $e) {
            \Log::error('QuoteItem store error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function editItem($id)
    {
        $item = QuoteItem::findOrFail($id);
        return view('sales.quotes.quote_items.edit', compact('item'));
    }

    public function showItem($id)
    {
        $item = QuoteItem::findOrFail($id);
        return view('sales.quotes.quote_items.show', compact('item'));
    }

    public function getItem($id, $itemId)
    {
        $item = QuoteItem::findOrFail($itemId);

        return response()->json(['success' => true, 'item' => $item]);
    }


    public function updateDetails(Request $request, $id)
    {
        $quote = Quote::findOrFail($id);

        $quote->update([
            'po_number'  => $request->po_number,
            'reference'  => $request->reference,
            'contact'    => $request->contact,
            'comment'    => $request->comment,
            'notes'      => $request->notes,
            'status'     => $request->status ?? 'draft',
        ]);

        if ($request->status === 'draft') {
            return redirect()->route('sales.quotes.index')->with('success', 'Quote saved as draft.');
        }

        return redirect()->route('sales.quotes.items', $quote->id)->with('success', 'Quote saved. Continue adding items.');
    }



    public function store(Request $request)
    {
        $lastQuote = Quote::latest('id')->first();
        $nextNumber = $lastQuote ? $lastQuote->id + 1 : 1;
        $quoteNumber = 'Q' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        $quote = Quote::create([
            'quote_number'      => $quoteNumber,
            'quote_number'      => $quoteNumber,
            'customer_number'   => $request->customer_number,
            'customer_name'     => $request->customer_name,
            'order_type'        => $request->order_type,
            'entry_date'        => $request->entry_date,
            'expected_delivery' => $request->expected_delivery,
            'valid_until'       => $request->valid_until,
            'entered_by'        => $request->entered_by,
            'region'            => $request->region,
            'measurement_type'  => $request->measurement_type,
            'po_number'         => $request->po_number,
            'reference'         => $request->reference,
            'contact'           => $request->contact,
            'comment'           => $request->comment,
            'notes'             => $request->notes,
            'status'            => $request->status ?? 'draft',
        ]);

        session([
            'quote_number'     => $quote->quote_number,
            'customer_number'  => $quote->customer_number,
            'customer_name'    => $quote->customer_name
        ]);

        return redirect()->route('sales.quotes.details', $quote->id);
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

    public function approveQuote($quoteId)
    {
        $quote = Quote::with('items')->findOrFail($quoteId);

        // 1. Create Order
        $order = Order::create([
            'quote_id' => $quote->id,
            'order_number' => generateOrderNumber(),
            'order_date' => now(),
            'due_date' => now()->addDays(14),
            'approved_by' => auth()->user()->name,
            'entered_by' => $quote->entered_by,

        ]);

        foreach ($quote->items as $item) {
            $order->items()->create($item->toArray());
        }

        // 2. Send Order PDF
        $pdf = Pdf::loadView('pdf.order', compact('order'));
        Mail::to($quote->customer->email)->send(new OrderGenerated($pdf));

        // 3. Create Invoice
        $invoice = Invoice::create([
            'order_id' => $order->id,
            'quote_id' => $quote->id,
            'invoice_number' => generateInvoiceNumber(),
            'work_order' => 'WO' . $order->id,
            'due_date' => now()->addDays(14),
            'entered_by' => auth()->user()->name,
            'status' => 'Pending',
        ]);

        return response()->json(['success' => true, 'order_id' => $order->id]);
    }

    public function preview($id)
    {
        $quote = Quote::with('items')->findOrFail($id);
        $pdf = Pdf::loadView('sales.quotes.preview', compact('quote'));
        return $pdf->stream("Quote_{$id}.pdf");
    }

    public function download($id)
    {
        $quote = Quote::with('items')->findOrFail($id);
        $pdf = Pdf::loadView('sales.quotes.preview', compact('quote'));
        return $pdf->download("Quote_{$id}.pdf");
    }

    public function send(Request $request, $id)
    {
        // logic to email the quote PDF
        return back()->with('success', 'Quote emailed successfully.');
    }

    public function save(Request $request, $id)
    {
        // logic to mark quote as saved/finalized
        return back()->with('success', 'Quote saved successfully.');
    }


    public function details($id)
    {
        $quote = Quote::findOrFail($id);
        session(['quote_number' => $quote->quote_number]);

        $seriesList = DB::table('elitevw_master_series')->pluck('series', 'id');

        $colorConfigurations = \App\Models\Master\Colors\ColorConfiguration::all();
        $exteriorColors = \App\Models\Master\Colors\ExteriorColor::all();
        $interiorColors = \App\Models\Master\Colors\InteriorColor::all();
        $laminateColors = \App\Models\Master\Colors\LaminateColor::all();

        $rawSeries = \App\Models\Master\Series\Series::all();

        $allConfigurations = [];

        foreach ($rawSeries as $series) {
            $seriesName = $series->series;
            $seriesFolder = public_path("config-thumbs/{$seriesName}");

            $seriesData = [];

            if (File::isDirectory($seriesFolder)) {
                $categoryFolders = File::directories($seriesFolder);

                foreach ($categoryFolders as $categoryPath) {
                    $category = basename($categoryPath);
                    $images = File::files($categoryPath);

                    foreach ($images as $img) {
                        if (in_array($img->getExtension(), ['png', 'jpg', 'jpeg'])) {
                            $name = pathinfo($img->getFilename(), PATHINFO_FILENAME);

                            $seriesData[] = [
                                'name' => strtoupper($name),
                                'image' => $img->getFilename(),
                                'series' => $seriesName,
                                'category' => $category
                            ];
                        }
                    }
                }
            }

            $allConfigurations[$series->id] = $seriesData;
        }

        $quoteItems = QuoteItem::where('quote_id', $quote->id)->get();


        return view('sales.quotes.details', compact(
            'quote',
            'seriesList',
            'colorConfigurations',
            'exteriorColors',
            'interiorColors',
            'laminateColors',
            'allConfigurations',
            'quoteItems'
        ));
    }


    private function guessCategory($series, $configName, $categories)
    {
        foreach ($categories as $cat) {
            $imagePath = public_path("config-thumbs/{$series}/{$cat}/" . strtolower($configName) . ".png");
            if (File::exists($imagePath)) {
                return $cat;
            }
        }

        return $categories[0] ?? 'General'; // fallback
    }





    public function getSeriesTypes($seriesId)
    {
        $types = DB::table('elitevw_master_series_types')
            ->where('series_id', $seriesId)
            ->pluck('series_type'); // returns collection of JSON strings

        $flattened = collect();

        foreach ($types as $json) {
            $decoded = json_decode($json, true); // decode JSON string into array
            if (is_array($decoded)) {
                $flattened = $flattened->merge($decoded);
            } else {
                // fallback if it's just a comma-separated string
                $flattened = $flattened->merge(explode(',', $json));
            }
        }

        return response()->json($flattened->unique()->values());
    }


    public function previous()
    {
        session(['returning_from_details' => true]);
        return redirect()->route('sales.quotes.create');
    }

    public function show($id)
    {
        $quote = Quote::findOrFail($id);
        $seriesList = Series::pluck('name', 'id');

        $colorConfigurations = \App\Models\Master\Colors\ColorConfiguration::all();
        $exteriorColors = \App\Models\Master\Colors\ExteriorColor::all();
        $interiorColors = \App\Models\Master\Colors\InteriorColor::all();
        $laminateColors = \App\Models\Master\Colors\LaminateColor::all();

        return view('sales.quotes.details', compact(
            'quote',
            'seriesList',
            'colorConfigurations',
            'exteriorColors',
            'interiorColors',
            'laminateColors'
        ));
    }

    public function edit($id)
    {
        $quote = Quote::with('items')->findOrFail($id);
        $seriesList = Series::pluck('name', 'id'); // or however you load it

        return view('sales.quotes.details', [
            'quote' => $quote,
            'quoteItems' => $quote->items,
            'seriesList' => $seriesList
        ]);
    }

    public function convertToOrder(Request $request, $id)
    {
        $quote = \App\Models\Sales\Quote::with('items')->findOrFail($id);

        // Create Order
        $order = \App\Models\Sales\Order::create([
            'quote_id'          => $quote->id,
            'customer_id'       => $quote->customer_id,
            'order_number'      => 'O' . str_pad(\App\Models\Sales\Order::max('id') + 1, 6, '0', STR_PAD_LEFT),
            'invoice_date'      => now()->toDateString(),
            'net_price'         => $quote->items->sum('total'),
            'status'            => 'draft',
            'notes'             => $quote->notes,
            'paid_amount'       => 0,
            'remaining_amount'  => $quote->items->sum('total'),
            'approved_by'       => null,
            'entered_by'        => auth()->user()->name,
            'due_date'          => now()->addDays(14)->toDateString(),
            'work_order_number' => 'WO' . str_pad(\App\Models\Sales\Order::max('id') + 1, 6, '0', STR_PAD_LEFT),
        ]);

        // Create Order Items from Quote Items
        foreach ($quote->items as $item) {
            $order->items()->create([
                'description'     => $item->description,
                'qty'             => $item->qty,
                'price'           => $item->price,
                'total'           => $item->total,
                'glass'           => $item->glass,
                'grid'            => $item->grid,
                'item_comment'    => $item->item_comment,
                'internal_note'   => $item->internal_note,
                'checked_count'   => $item->checked_count,
                'image'           => $item->image, // optional
                // Add any other shared fields here
            ]);
        }

        return redirect()->route('sales.orders.show', $order->id)->with('success', 'Quote converted to Order successfully.');
    }

    public function destroyItem(Request $request, $id)
    {
        $itemId = $request->input('item_id');
        $item = QuoteItem::find($itemId);
        $item?->delete();

        return response()->json(['success' => true, 'message' => 'Item deleted successfully.']);
    }
}
