<?php

namespace App\Http\Controllers\Miscellaneous;

use App\Http\Controllers\Controller;
use App\Models\Miscellaneous\Parking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ParkingController extends Controller
{
    public function index(Request $request)
    {
        // Ensure 1..50 rows exist
        for ($i = 1; $i <= 50; $i++) {
            Parking::firstOrCreate(
                ['spot' => (string) $i],
                ['user_id' => null, 'notes' => null, 'wheelchair' => false]
            );
        }

        $q = trim((string) $request->get('q', ''));

        // Eager-load roles to show department without N+1
        $assignments = Parking::with(['user.roles'])
            ->when($q !== '', function ($qq) use ($q) {
                $qq->where('spot', 'like', "%{$q}%")
                   ->orWhereHas('user', function ($uq) use ($q) {
                       $uq->where('name', 'like', "%{$q}%")
                          ->orWhere('email', 'like', "%{$q}%");
                   });
            })
            ->orderByRaw('CAST(spot AS UNSIGNED) asc')
            ->get();

        return view('miscellaneous.parking.index', compact('assignments', 'q'));
    }

    public function create()
    {
        // Users without any parking row yet
        $users = User::leftJoin('elitevw_miscellaneous_parking as p', 'p.user_id', '=', 'users.id')
            ->whereNull('p.id')
            ->orderBy('users.name')
            ->select('users.*')
            ->get();

        return view('miscellaneous.parking.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'    => ['required','integer','exists:users,id', Rule::unique('elitevw_miscellaneous_parking', 'user_id')],
            'spot'       => ['required','string','max:50', Rule::unique('elitevw_miscellaneous_parking', 'spot')],
            'notes'      => ['nullable','string'],
            'wheelchair' => ['boolean'],
        ]);

        Parking::create([
            'user_id'    => $request->integer('user_id'),
            'spot'       => (string) $request->input('spot'),
            'notes'      => $request->input('notes'),
            'wheelchair' => (int) $request->input('wheelchair', 0),
        ]);

        return redirect()->route('misc.parking.index')->with('success', 'Parking assigned.');
    }

    public function edit(Parking $parking)
    {
        // Allow switching to any unassigned user + keep current user
        $users = User::leftJoin('elitevw_miscellaneous_parking as p', 'p.user_id', '=', 'users.id')
            ->whereNull('p.id')
            ->orWhere('users.id', $parking->user_id)
            ->orderBy('users.name')
            ->select('users.*')
            ->get()
            ->unique('id')
            ->values();

        return view('miscellaneous.parking.edit', [
            'assignment' => $parking->load('user.roles'),
            'users'      => $users,
        ]);
    }

    public function update(Request $request, Parking $parking)
    {
        $request->validate([
            'user_id'    => ['nullable','integer','exists:users,id', Rule::unique('elitevw_miscellaneous_parking', 'user_id')->ignore($parking->id)],
            'spot'       => ['required','string','max:50', Rule::unique('elitevw_miscellaneous_parking', 'spot')->ignore($parking->id)],
            'notes'      => ['nullable','string'],
            'wheelchair' => ['boolean'],
        ]);

        $parking->update([
            'user_id'    => $request->filled('user_id') ? $request->integer('user_id') : null,
            'spot'       => (string) $request->input('spot'),
            'notes'      => $request->input('notes'),
            'wheelchair' => (int) $request->input('wheelchair', 0),
        ]);

        return redirect()->route('misc.parking.index')->with('success', 'Parking updated.');
    }

    public function destroy(Parking $parking)
    {
        $parking->delete();
        return redirect()->route('misc.parking.index')->with('success', 'Parking removed.');
    }

    // app/Http/Controllers/Miscellaneous/ParkingController.php

public function show(Parking $parking)
{
    // eager-load roles for “Department”
    $parking->load('user.roles');
    return view('miscellaneous.parking.show', [
        'assignment' => $parking,
    ]);
}

}
