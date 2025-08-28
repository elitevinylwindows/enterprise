<?php
// app/Http/Controllers/Admin/NfrcWindowTypeController.php
namespace App\Http\Controllers\Rating;

use App\Http\Controllers\Controller;
use App\Models\NfrcWindowType;
use Illuminate\Http\Request;

class NfrcWindowTypeController extends Controller
{
    public function index(Request $request)
    {
        $q = NfrcWindowType::query();
        if ($s = trim($request->get('s',''))) {
            $q->where(function($w) use ($s) {
                $w->where('name','like',"%$s%")->orWhere('slug','like',"%$s%");
            });
        }
        $types = $q->orderBy('name')->paginate(20)->withQueryString();
        return view('admin.nfrc.window_types.index', compact('types','s'));
    }

    public function create()
    {
        return view('admin.nfrc.window_types.create');
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'name' => 'required|string|max:120',
            'slug' => 'required|string|max:80|unique:elitevw_ratings_nfrc.nfrc_window_types,slug',
        ]);
        NfrcWindowType::create($data);
        return redirect()->route('admin.nfrc.window-types.index')->with('success','Window type created.');
    }

    public function edit(NfrcWindowType $type)
    {
        return view('admin.nfrc.window_types.edit', compact('type'));
    }

    public function update(Request $r, NfrcWindowType $type)
    {
        $data = $r->validate([
            'name' => 'required|string|max:120',
            'slug' => 'required|string|max:80|unique:elitevw_ratings_nfrc.nfrc_window_types,slug,'.$type->id,
        ]);
        $type->update($data);
        return redirect()->route('admin.nfrc.window-types.index')->with('success','Window type updated.');
    }

    public function destroy(NfrcWindowType $type)
    {
        $type->delete();
        return redirect()->route('admin.nfrc.window-types.index')->with('success','Window type deleted.');
    }
}
