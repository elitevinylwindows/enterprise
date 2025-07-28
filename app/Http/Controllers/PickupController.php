<?php

namespace App\Http\Controllers;
use App\Models\Pickup;
use Illuminate\Http\Request;
use App\Models\Delivery;


class PickupController extends Controller
{
public function index()
{
    $pickups = \App\Models\Delivery::where('is_delivery', 0)->get();

    return view('pickups.index', compact('pickups'));
}

public function edit(Delivery $pickup)
{
    return view('pickups.modals.edit', compact('pickup'));
}


    public function show(Delivery $pickup)
{
    return view('pickups.modals.show', compact('pickup'));
}




public function destroy(Delivery $pickup)
{
    $pickup->delete();

    return redirect()->route('pickup.index')->with('success', 'Pickup deleted.');
}

public function update(Request $request, Delivery $pickup)
{
    $request->validate([
        'status' => 'required|string',
        'date_picked_up' => 'nullable|date',
    ]);

    $pickup->update([
        'status' => $request->status,
        'date_picked_up' => $request->date_picked_up,
    ]);

    return redirect()->back()->with('success', 'Pickup updated.');
}


}
