<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SrDeliveryController extends Controller
{
    public function index()
    {
        return view('sr.deliveries.all');
    }

    public function today()
    {
        return view('sr.deliveries.today');
    }

    public function upcoming()
    {
        return view('sr.deliveries.upcoming');
    }
}
