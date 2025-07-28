<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class RaffleDrawController extends Controller
{
    public function index()
    {
        $winner = session('raffle_winner');
        return view('executives.raffle.index', compact('winner'));
    }

    public function start()
    {
        $customer = Customer::inRandomOrder()->first();

        session(['raffle_winner' => $customer]);
        return back()->with('success', 'Raffle winner selected!');
    }

    public function reset()
    {
        session()->forget('raffle_winner');
        return back()->with('success', 'Raffle reset.');
    }
}
