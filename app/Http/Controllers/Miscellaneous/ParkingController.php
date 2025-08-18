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
        $q = trim((string) $request->get('q', ''));

        $assignments = Parking::with('user')
            ->when($q !== '', function ($qq) use ($q) {
                $qq->where('spot', 'like', "%{$q}%")
                   ->orWhereHas('user', function ($uq) use ($q) {
                       $uq->where('name', 'like', "%{$q}%")
                          ->orWhere('email', 'like', "%{$q}%");
                   });
            })
            ->orderBy('spot')
            ->get();

        return view('miscellaneous.parking.index', compact('assignments', 'q'));
    }

    public function create()
    {
        // users without an existing parking row
        $users = User::leftJoin('elitevw_miscellaneous_parking as p', 'p.user_id', '=', 'users.id')
            ->whereNull('p.id')
            ->orderBy('users.name')
            ->select('users.*')
            ->get();

        // return modal partial
        return view('miscellaneous.parking.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => [
                'required', 'integer', 'exists:users,id',
                Rule::unique('elitevw_miscellaneous_parking', 'user_id'),
            ],
            'spot'  => ['required', 'string', 'max:50',
                Rule::unique('elitevw_miscellaneous_parking', 'spot'),
            ],
            'notes' => ['nullable', 'string'],
        ]);

        Parking::create($request->only('user_id', 'spot', 'notes'));

        return redirect()->route('misc.parking.index')->with('success', 'Parking assigned.');
    }

    public function edit(Parking $parking)
    {
        // allow switching to any unassigned user + keep current
        $users = User::leftJoin('elitevw_miscellaneous_parking as p', 'p.user_id', '=', 'users.id')
            ->whereNull('p.id')
            ->orWhere('users.id', $parking->user_id)
            ->orderBy('users.name')
            ->select('users.*')
            ->get()
            ->unique('id')
            ->values();

        // return modal partial
        return view('miscellaneous.parking.edit', [
            'assignment' => $parking,
            'users'      => $users,
        ]);
    }

    public function update(Request $request, Parking $parking)
    {
        $request->validate([
            'user_id' => [
                'required', 'integer', 'exists:users,id',
                Rule::unique('elitevw_miscellaneous_parking', 'user_id')->ignore($parking->id),
            ],
            'spot'  => [
                'required', 'string', 'max:50',
                Rule::unique('elitevw_miscellaneous_parking', 'spot')->ignore($parking->id),
            ],
            'notes' => ['nullable', 'string'],
        ]);

        $parking->update($request->only('user_id', 'spot', 'notes'));

        return redirect()->route('misc.parking.index')->with('success', 'Parking updated.');
    }

    public function destroy(Parking $parking)
    {
        $parking->delete();
        return redirect()->route('misc.parking.index')->with('success', 'Parking removed.');
    }
}
