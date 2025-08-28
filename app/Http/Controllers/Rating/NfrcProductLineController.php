<?php
// app/Http/Controllers/Admin/NfrcProductLineController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rating\NfrcProductLine;
use App\Models\Rating\NfrcWindowType;
use Illuminate\Http\Request;

class NfrcProductLineController extends Controller
{
    public function index(Request $request)
    {
        $typeId = $request->get('type_id');
        $q = NfrcProductLine::with('type');
        if ($typeId) $q->where('window_type_id', $typeId);
        if ($s = trim($request->get('s',''))) {
            $q->where(function($w) use ($s) {
                $w->where('manufacturer','like',"%$s%")
                  ->orWhere('series_model','like',"%$s%")
                  ->orWhere('product_line','like',"%$s%");
            });
        }
        $lines = $q->orderBy('series_model')->orderBy('product_line')->paginate(20)->withQueryString();
        $types = NfrcWindowType::orderBy('name')->get(['id','name']);
        return view('admin.nfrc.product_lines.index', compact('lines','types','typeId','s'));
    }

    public function create()
    {
        $types = NfrcWindowType::orderBy('name')->get(['id','name']);
        return view('admin.nfrc.product_lines.create', compact('types'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'window_type_id'  => 'required|exists:elitevw_ratings_nfrc.nfrc_window_types,id',
            'manufacturer'    => 'required|string|max:160',
            'series_model'    => 'required|string|max:160',
            'product_line'    => 'required|string|max:160',
            'product_line_url'=> 'nullable|url|max:512',
            'is_energy_star'  => 'nullable|boolean',
        ]);
        $data['is_energy_star'] = (bool)($data['is_energy_star'] ?? false);
        NfrcProductLine::create($data);
        return redirect()->route('admin.nfrc.product-lines.index')->with('success','Product line created.');
    }

    public function edit(NfrcProductLine $line)
    {
        $types = NfrcWindowType::orderBy('name')->get(['id','name']);
        return view('admin.nfrc.product_lines.edit', compact('line','types'));
    }

    public function update(Request $r, NfrcProductLine $line)
    {
        $data = $r->validate([
            'window_type_id'  => 'required|exists:elitevw_ratings_nfrc.nfrc_window_types,id',
            'manufacturer'    => 'required|string|max:160',
            'series_model'    => 'required|string|max:160',
            'product_line'    => 'required|string|max:160',
            'product_line_url'=> 'nullable|url|max:512',
            'is_energy_star'  => 'nullable|boolean',
        ]);
        $data['is_energy_star'] = (bool)($data['is_energy_star'] ?? false);
        $line->update($data);
        return redirect()->route('admin.nfrc.product-lines.index')->with('success','Product line updated.');
    }

    public function destroy(NfrcProductLine $line)
    {
        $line->delete();
        return redirect()->route('admin.nfrc.product-lines.index')->with('success','Product line deleted.');
    }
}
