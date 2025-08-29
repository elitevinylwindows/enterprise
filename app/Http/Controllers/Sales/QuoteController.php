<?php

namespace App\Http\Controllers\Sales;

use App\Helper\FirstServe;
use App\Http\Controllers\Controller;
use App\Mail\OrderMail;
use App\Mail\QuoteEmail;
use Illuminate\Http\Request;
use App\Models\Sales\Quote;
use App\Models\Master\Series\Series;
use App\Models\Master\Series\SeriesType;
use App\Models\Master\Customers\Customer;
use App\Models\Master\Prices\TaxCode;
use App\Models\Master\Series\SeriesConfiguration;
use App\Models\Sales\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Sales\QuoteItem;
use App\Models\Schemas\CMUnit;
use App\Models\Schemas\DHUnit;
use App\Models\Schemas\HSUnit;
use App\Models\Schemas\PWUnit;
use App\Models\Schemas\SHUnit;
use App\Models\Schemas\SLDUnit;
use App\Models\Schemas\SWDUnit;
use App\Services\RingCentralService;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;
use GuzzleHttp\Psr7\Query;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class QuoteController extends Controller
{

public function index(Request $request)
{
    $status = $request->get('status', 'all');

    $quotes = Quote::query();

    if ($status === 'deleted') {
        $quotes->onlyTrashed(); // Get only soft-deleted quotes
    } elseif ($status !== 'all') {
        $quotes->where('status', $status); // Filter by status for non-deleted
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
            ->where('series_type', $request->series_type)
            ->first();

        $price = DB::table('elitevw_master_price_price_matrices')
            ->where('series_id', $request->series_id)
            ->where('series_type_id', $seriesType->id)
            ->where('width', $request->width)
            ->where('height', $request->height)
            ->value('price');

        $price = getMarkup($request->series_id, $price);
        $customer = Customer::where('customer_number', $request->customer_number)
            ->first();
        $percentage = $customer->tier?->percentage;
        $discount = ($percentage * ($price / 100));

        \Log::info('Checking price matrix', [
            'series_id' => $request->series_id,
            'series_type' => $request->series_type,
            'width' => $request->width,
            'height' => $request->height,
            'price_found' => $price
        ]);

        return response()->json(['price' => $price, 'discount' => $discount]);
    }


    public function storeItem(Request $request, $id)
    {
        try {
           $validated =  $request->validate([
                'description' => 'required|string',
                'series_id' => 'required|integer|exists:elitevw_master_series,id',
                'series_type' => 'required|string',
                'item_id' => ' nullable|integer',
                'width' => 'required|numeric',
                'height' => 'required|numeric',
                'glass' => 'nullable|string',
                'grid' => 'nullable|string',
                'qty' => 'required|numeric',
                'price' => 'required|numeric',
                'total' => 'required|numeric',
                'discount' => 'required|numeric',
                'item_comment' => 'nullable|string',
                'internal_note' => 'nullable|string',
                'color_config' => 'nullable|string',
                'color_exterior' => 'nullable|string',
                'color_interior' => 'nullable|string',
                'frame_type' => 'nullable|string',
                'fin_type' => 'nullable|string',
                'glass_type' => 'nullable|string',
                'spacer' => 'nullable|string',
                'tempered' => 'nullable|string',
                'tempered_fields' => 'nullable|array',
                'specialty_glass' => 'nullable|string',
                'grid_pattern' => 'nullable|string',
                'grid_profile' => 'nullable|string',
                'retrofit_bottom_only' => 'nullable|boolean',
                'no_logo_lock' => 'nullable|boolean',
                'double_lock' => 'nullable|boolean',
                'custom_lock_position' => 'nullable|boolean',
                'custom_vent_latch' => 'nullable|boolean',
                'knocked_down' => 'nullable|boolean',
                'is_modification' => 'nullable',
                'addon' => 'nullable|string',
            ]);

            $isUpdate = false;
            // Check if item already exists
            if (isset($validated['item_id'])) {

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
                        'discount' => $request->discount,
                        'item_comment' => $request->item_comment,
                        'internal_note' => $request->internal_note,
                        'color_config' => $request->color_config,
                        'color_exterior' => $request->color_exterior,
                        'color_interior' => $request->color_interior,
                        'frame_type' => $request->frame_type,
                        'tempered_fields' => json_encode($request->tempered_fields ?? []),
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
                        'addon' => $request->addon
                    ]);

                    $oldDiscount = $existingItem->quote->discount;

                    $existingItem->quote->update([
                        'discount' => $oldDiscount + $request->discount
                    ]);
                }
                $item = QuoteItem::where('id', $validated['item_id'])->first();
                $isUpdate = true;
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
                    'discount' => $request->discount,
                    'price' => $request->price,
                    'total' => $request->total,
                    'item_comment' => $request->item_comment,
                    'internal_note' => $request->internal_note,
                    'color_config' => $request->color_config,
                    'color_exterior' => $request->color_exterior,
                    'color_interior' => $request->color_interior,
                    'frame_type' => $request->frame_type,
                    'fin_type' => $request->fin_type,
                    'tempered_fields' => json_encode($request->tempered_fields ?? []),
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
                    'is_modification' => (bool) $request->is_modification,
                    'modification_date' => (bool) $request->is_modification ? now() : null,
                    'addon' => $request->addon
                ]);

                // Update the quote's discount with the previous value before this item was added/updated
                $oldDiscount = $item->quote->discount;

                $item->quote->update([
                    'discount' => $oldDiscount + $request->discount
                ]);
            }

            $allModifications = QuoteItem::where('quote_id', $id)
                ->where('is_modification', true)
                ->get()
                ->groupBy(function ($item) {
                    return \Carbon\Carbon::parse($item->modification_date)->format('Y-m-d h:i A');
                });

            return response()->json([
                'success' => true,
                'is_modification' => $validated['is_modification'] ?? false,
                'item_id' => $item->id,
                'item' => $item,
                'is_update' => $isUpdate ?? false,
                'modifications' => $allModifications ?? [],
            ]);
        } catch (\Exception $e) {
            Log::error($e);
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

    public function getItem($id, $itemId, $type = 'quote_item')
    {
        if($type == 'quote_item') {
            $item = QuoteItem::findOrFail($itemId);
        } elseif($type == 'modification') {
            $item = QuoteItem::where('id', $itemId)->where('is_modification', true)->firstOrFail();
        }

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
        try{
            DB::beginTransaction();

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

            DB::commit();

            return redirect()->route('sales.quotes.details', $quote->id);
        } catch(\Exception $e) {
            dd($e);
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create quote. Please try again later.']);
        }
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

        $modificationsByDate = $quote->items->where('is_modification', true)->groupBy(function ($mod) {
            return \Carbon\Carbon::parse($mod->modification_date)->format('Y-m-d h:i A');
        });


        return view('sales.quotes.preview', compact('quote', 'modificationsByDate'));
    }

    public function download($id)
    {
        $quote = Quote::with('items')->findOrFail($id);
        $modificationsByDate = $quote->items->where('is_modification', true)->groupBy(function ($mod) {
            return \Carbon\Carbon::parse($mod->modification_date)->format('Y-m-d h:i A');
        });
        $pdf = Pdf::loadView('sales.quotes.preview', compact('quote', 'modificationsByDate'));
        return $pdf->download("Quote_{$id}.pdf");
    }

    public function send($id)
    {
        $quote = Quote::findOrFail($id);

        $modificationsByDate = $quote->items->where('is_modification', true)->groupBy(function ($mod) {
            return \Carbon\Carbon::parse($mod->modification_date)->format('Y-m-d h:i A');
        });

        $pdf = Pdf::loadView('sales.quotes.preview', compact('quote', 'modificationsByDate'));

        try {
            Mail::to($quote->customer->email)
            ->send(new QuoteEmail($quote, $pdf));
            $quote->status = 'sent';
            $quote->save();
            return back()->with('success', 'Quote emailed successfully.');
        } catch (\Exception $e) {
            dd($e);
            Log::error('Error sending quote email: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to send email. Please try again later.']);
        }

    }

    public function save(Request $request, $id)
    {
        // logic to mark quote as saved/finalized
        return back()->with('success', 'Quote saved successfully.');
    }

    public function view($id)
    {
        $quote = Quote::findOrFail($id);

        $modificationsByDate = $quote->items->where('is_modification', true)->groupBy(function ($mod) {
            return \Carbon\Carbon::parse($mod->modification_date)->format('Y-m-d h:i A');
        });

        return view('sales.quotes.view', compact('quote', 'modificationsByDate'));
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

        $taxCode = TaxCode::where('city', $quote->customer->billing_city)->first();

        if ($taxCode) {
            $taxRate = $taxCode->rate;
        } else
        {
            $taxRate = 0; // Default tax rate if no code found
        }

        return view('sales.quotes.details', compact(
            'quote',
            'seriesList',
            'colorConfigurations',
            'exteriorColors',
            'interiorColors',
            'laminateColors',
            'allConfigurations',
            'quoteItems',
            'taxRate',
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


    public function previous($id)
    {
        $quote = Quote::findOrFail($id);
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

        return view('sales.quotes.edit_initial', [
            'quote' => $quote,
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

    public function show($id)
    {
        $quote = Quote::findOrFail($id);
        $seriesList = Series::pluck('series', 'id');

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
        $quote = Quote::with(['items'])->findOrFail($id);


        // Group modifications by created date (Y-m-d)
        $modificationsByDate = $quote->items->where('is_modification', true)->groupBy(function ($mod) {
            return \Carbon\Carbon::parse($mod->modification_date)->format('Y-m-d h:i A');
        });


        $seriesList = DB::table('elitevw_master_series')->pluck('series', 'id');

        $colorConfigurations = \App\Models\Master\Colors\ColorConfiguration::all();
        $exteriorColors = \App\Models\Master\Colors\ExteriorColor::all();
        $interiorColors = \App\Models\Master\Colors\InteriorColor::all();
        $laminateColors = \App\Models\Master\Colors\LaminateColor::all();
        $quoteItems = QuoteItem::where('quote_id', $quote->id)->where('is_modification', false)->get();

        $rawSeries = \App\Models\Master\Series\Series::all();
        $taxCode = TaxCode::where('city', $quote->customer->billing_city)->first();

        if ($taxCode) {
            $taxRate = $taxCode->rate;
        } else
        {
            $taxRate = 0; // Default tax rate if no code found
        }
        return view('sales.quotes.edit', compact(
            'quote',
            'seriesList',
            'colorConfigurations',
            'exteriorColors',
            'interiorColors',
            'laminateColors',
            'quoteItems',
            'taxRate',
            'modificationsByDate'
        ));
    }

    public function convertToOrder(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $quote = \App\Models\Sales\Quote::with('items')->findOrFail($id);
            $order = quoteToOrder($quote);

                sendOrderMail($order);

            DB::commit();
        return redirect()->route('sales.orders.index', $order->id)->with('success', 'Quote converted to Order successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error converting quote to order: ' . $e->getMessage());
            return redirect()->route('sales.quotes.index')->withErrors(['error' => 'Failed to convert quote to order.']);
        }
    }

    public function destroyItem($id, $itemId, $type = 'quote_item')
    {
        if($type == 'quote_item')
        {

            $item = QuoteItem::find($itemId);
            if(!$item) {
                return response()->json(['success' => false, 'message' => 'Item not found.'], 404);
            }

            $data = calculateTotal($item->quote, $item->quote->shipping);

            $item->quote->update([
                'discount' => $item->quote->discount - $item->discount,
                'total'     => max(0, $data['total']),
                'sub_total' => max(0, $data['sub_total']),
            ]);
            $item->delete();
        } else if($type == 'modification') {
            $item = QuoteItem::where('id', $itemId)->where('is_modification', true)->first();
            if(!$item) {
                return response()->json(['success' => false, 'message' => 'Item not found.'], 404);
            }

            $data = calculateTotal($item->quote, $item->quote->shipping);
            $item->quote->update([
                'discount' => $item->quote->discount - $item->discount,
                'total'     => max(0, $data['total']),
                'sub_total' => max(0, $data['sub_total']),
            ]);

            $item->delete();

        }
        return response()->json(['success' => true, 'message' => 'Item deleted successfully.']);
    }

    public function destroy($id)
    {
        $quote = Quote::findOrFail($id);
        $quote->items()->delete(); // Delete all associated items
        $quote->delete();
        return redirect()->route('sales.quotes.index')->with('success', 'Quote deleted successfully.');
    }

    public function previewPDF($id)
    {
        $quote = Quote::find($id);
        $order = $quote->order ?? null;
        if($order) {
            $pdf = PDF::loadView('sales.orders.preview_pdf', compact('order'))->setPaper('a4', 'landscape');
            return $pdf->stream('quote-' . $order->id . '.pdf');
        }
        return redirect()->back()->withErrors(['error' => 'Quote not found or has no associated order.']);
    }

    public function updateStatus($id, $status)
    {
        $quote = Quote::findOrFail($id);
        try {
            DB::beginTransaction();
            if ($status === 'approved') {
                $order = quoteToOrder($quote);

                sendOrderMail($order);

                quoteToInvoice($quote, $order);

                if (!$order) {
                    return redirect()->route('sales.quotes.index')->withErrors(['error' => 'Failed to convert quote to order.']);
                }

                $quote->approved_at = now();
            }

            $quote->status = $status;
            $quote->save();
            DB::commit();
            return redirect()->route('sales.quotes.index')->with('success', 'Quote status updated successfully.');
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return redirect()->route('sales.quotes.index')->withErrors(['error' => 'Failed to update quote status.']);
        }

    }

    public function saveDraft(Request $request, $id)
    {
        $quote = Quote::findOrFail($id);
        $quote->status = $request->status ?? 'draft';
        $quote->discount = $request->discount ?? 0;
        $quote->shipping = $request->shipping ?? 0;
        $quote->sub_total = $request->subtotal ?? 0;
        $quote->tax = $request->tax ?? 0;
        $quote->total = $request->total ?? 0;
        $quote->save();

         $modificationsByDate = $quote->items->where('is_modification', true)->groupBy(function ($mod) {
            return \Carbon\Carbon::parse($mod->modification_date)->format('Y-m-d h:i A');
        });

        // Get customer preferences (array: ['email', 'sms'] or just one)
        $preferences = [];
        if ($quote->customer && $quote->customer->receive_quote_via) {
            $preferences = json_decode($quote->customer->receive_quote_via, true) ?? [];
        }

        if ($request->status === 'Quote Submitted') {
            $pdf = Pdf::loadView('sales.quotes.preview_pdf', ['quote' => $quote, 'modificationsByDate' => $modificationsByDate])->setPaper('a4', 'landscape');
            $pdfPath = 'quotes/quote_' . $quote->quote_number . '.pdf';

            // Always generate PDF and store
            Storage::disk('public')->put($pdfPath, $pdf->output());

            // Send email if preferred
            // if (in_array('email', $preferences) && $quote->customer->email) {
            //     Mail::to($quote->customer->email)
            //         ->send(new QuoteEmail($quote, $pdfPath));

            //     $quote->update(['status' => 'Sent For Approval']);
            // }

            // Send SMS if preferred
            if (in_array('sms', $preferences) && $quote->customer->billing_phone) {
                $rcService = new RingCentralService();
                $result = $rcService->sendQuoteApprovalSms(
                    $quote->customer->billing_phone,
                    $quote->quote_number,
                    $quote->customer->customer_name,
                    $pdfPath
                );

                // Update quote status to "sent_for_approval" if SMS sent
                if (isset($result['data']->messageStatus)) {
                    $quote->update(['status' => 'Sent For Approval']);
                }
            }
        }

        return response()->json(['success' => true, 'message' => 'Quote sent for approval.']);
    }

    public function email($id)
    {
        $quote = Quote::findOrFail($id);
        Mail::to($quote->customer->email)->send(new QuoteEmail($quote));

        return response()->json(['success' => true, 'message' => 'Quote emailed successfully.']);
    }

    public function fetchInfo($id)
    {
        try{
            $quote = Quote::where('quote_number', $id)->with(['items','customer', 'order'])->first();
            $order = (Order::max('id') ?? 0) + 1;
            $generatedOrderNumber = 'ORD-' . str_pad($order, 5, '0', STR_PAD_LEFT);
            $generatedInvoiceNumber = generateInvoiceNumber();

            return response()->json(['success' => true, 'message' => 'Quote fetched successfully.', 'data' => ['quote' => $quote, 'order_number' => $generatedOrderNumber, 'invoice_number' => $generatedInvoiceNumber]]);
        } catch (\Exception $e) {
            Log::error('Error fetching quote info: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to fetch quote info.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
                'customer_number'   => 'required|string',
                'customer_name'     => 'required|string',
                'order_type'        => 'required|string',
                'entry_date'        => 'required|date',
                'expected_delivery' => 'required|date',
                'valid_until'       => 'required|date',
                'entered_by'        => 'required|string',
                'region'            => 'nullable|string',
                'measurement_type'  => 'nullable|string',
                'po_number'         => 'nullable|string',
                'reference'         => 'nullable|string',
                'contact'           => 'nullable|string',
                'comment'           => 'nullable|string',
                'notes'             => 'nullable|string',
            ]);

           try{
            DB::beginTransaction();
            $quote = Quote::findOrFail($id);

            $quote->update([
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

            DB::commit();

            return redirect()->route('sales.quotes.details', $quote->id);
        } catch(\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to edit quote. Please try again later.']);
        }
    }



    public function restore($id)
    {
        Quote::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('sales.quotes.index', ['status' => 'deleted'])
            ->with('success', 'Quote restored successfully');
    }

    public function forceDelete($id)
    {
        Quote::withTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('sales.quotes.index', ['status' => 'deleted'])
            ->with('success', 'Quote permanently deleted');
    }

    public function calculateTotal(Request $request)
    {
        $quote = Quote::findOrFail($request->quote_id);

        $data = calculateTotal($quote, $request->shipping);

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function updateQty($quoteId, $itemId)
    {
        $quote = Quote::findOrFail($quoteId);
        $item = QuoteItem::findOrFail($itemId);
        $item->qty = request()->input('qty');
        $item->total = $item->qty * $item->price;
        $item->save();

        return response()->json(['success' => true, 'data' => $item]);

    }

    public function sendMessage($id)
    {
        $quote = Quote::findOrFail($id);
        $rcService = new RingCentralService();

        $pdfPath = 'quotes/quote_'.$quote->quote_number.'.pdf';

        $result = $rcService->sendQuoteApprovalSms(
                    $quote->customer->billing_phone, // e.g., +15558675309
                    $quote->quote_number,
                    $quote->customer->customer_name,
                    $pdfPath
                );

        $quote->update(['ringcentral_message_id' => $result['data']->conversation->id]);
        dd($result);
    }

    public function getSchemaPrice(Request $request)
    {
        $validated = $request->validate([
            'dropdown_value' => 'required|string',
            'series_type' => 'required|string',
            'series' => 'required|string',
        ]);

        $series = Series::where('id', $validated['series'])->first();

        $seriesType = SeriesConfiguration::with([
                'productTypes' => function ($query) use ($series) {
                    $query->where('series', $series->series);
                }
            ])
            ->where('series_type', $validated['series_type'])
            ->first();

            if (!$seriesType->productTypes->isEmpty()) {
                $description = strtoupper($seriesType->productTypes[0]->description); // normalize to uppercase
                // ✅ Define mappings: keyword => model
                $mappings = [
                    'HORIZONTAL SLIDING' => HSUnit::class,
                    'SINGLE HUNG'        => SHUnit::class,
                    'PICTURE'            => PWUnit::class,
                    'SWING DOOR'              => SWDUnit::class,
                    'SLIDING DOOR'              => SLDUnit::class,
                    'CASEMENT/AWNING' => CMUnit::class,
                    'DOUBLE HUNG' => DHUnit::class,
                    'SLIDING DOOR' => SLDUnit::class,
                ];

                $model = null;

                foreach ($mappings as $keyword => $mappedModel) {
                    if (str_contains($description, $keyword)) {
                        $model = $mappedModel;
                        break;
                    }
                }
                if ($model) {
                    // Example: fetch record from that model
                    $unit = $model::where('schema_id', $validated['series'])->first(); // change to ->where(...) as needed
                    $column = str_replace('/','_', strtolower($validated['dropdown_value']));

                    $addOnPrice = $unit?->$column;
                    if (!$addOnPrice) {
                        $addOnPrice = 0;
                    }
                } else {
                    $addOnPrice = 0;
                    dd("No matching model found for description: " . $description);
                }

                return response()->json(['success' => true, 'price' => (float)$addOnPrice]);
            }
        return response()->json(['success' => false, 'message' => 'Series type not found']);
    }
}
