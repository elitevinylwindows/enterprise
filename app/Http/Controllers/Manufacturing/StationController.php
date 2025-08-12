<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use App\Models\Manufacturing\Station;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StationController extends Controller
{
    /**
     * GET /manufacturing/stations?status=all|active|inactive|deleted
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        if ($status === 'deleted') {
            $stations = Station::onlyTrashed()->orderByDesc('id')->get();
        } else {
            $query = Station::query();

            if (in_array($status, ['active', 'inactive'], true)) {
                $query->where('status', $status);
            }

            $stations = $query->orderByDesc('id')->get();
        }

        return view('manufacturing.stations.index', [
            'stations' => $stations,
            'status'   => $status,
        ]);
    }

    public function create()
    {
        return view('manufacturing.stations.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'station_number' => [
                'required', 'string', 'max:50',
                Rule::unique('elitevw_manufacturing_stations', 'station_number'),
            ],
            'description' => ['nullable', 'string'],
            'status'      => ['required', Rule::in(['active', 'inactive'])],
        ]);

        Station::create($data);

        return redirect()->route('manufacturing.stations.index')
            ->with('success', 'Station created.');
    }

    public function show(Station $station)
    {
        return view('manufacturing.stations.show', compact('station'));
    }

    public function edit(Station $station)
    {
        return view('manufacturing.stations.edit', compact('station'));
    }

    public function update(Request $request, Station $station)
    {
        $data = $request->validate([
            'station_number' => [
                'required', 'string', 'max:50',
                Rule::unique('elitevw_manufacturing_stations', 'station_number')->ignore($station->id),
            ],
            'description' => ['nullable', 'string'],
            'status'      => ['required', Rule::in(['active', 'inactive'])],
        ]);

        $station->update($data);

        return redirect()->route('manufacturing.stations.index')
            ->with('success', 'Station updated.');
    }

    /**
     * Soft delete
     */
    public function destroy(Station $station)
    {
        $station->delete();

        return redirect()->route('manufacturing.stations.index', ['status' => 'deleted'])
            ->with('success', 'Station deleted.');
    }

    /**
     * POST /manufacturing/stations/{id}/restore
     */
    public function restore($id)
    {
        $station = Station::onlyTrashed()->findOrFail($id);
        $station->restore();

        return redirect()->route('manufacturing.stations.index')
            ->with('success', 'Station restored.');
    }

    /**
     * DELETE /manufacturing/stations/{id}/force
     */
    public function forceDelete($id)
    {
        $station = Station::onlyTrashed()->findOrFail($id);
        $station->forceDelete();

        return redirect()->route('manufacturing.stations.index', ['status' => 'deleted'])
            ->with('success', 'Station permanently deleted.');
    }
}
