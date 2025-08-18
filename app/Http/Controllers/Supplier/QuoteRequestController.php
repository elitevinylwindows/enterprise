<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Sales\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class QuoteRequestController extends Controller
{
    public function secureView($token)
    {
        try {
            $decryptedId = Crypt::decryptString($token);
            $quote = Quote::with(['items', 'customer'])->findOrFail($decryptedId);
            $modificationsByDate = $quote->items->where('is_modification', true)->groupBy(function ($mod) {
                return \Carbon\Carbon::parse($mod->modification_date)->toDateString();
            });
        } catch (\Exception $e) {
            abort(403, 'Invalid or expired token.');
        }

        return view('sales.quotes.secure_view', compact('quote', 'modificationsByDate'));
    }
}
