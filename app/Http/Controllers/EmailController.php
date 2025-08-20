<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * Show the Email index page.
     */
    public function index()
    {
        // you can pass sample data to your view later
        // for now just load the blade
        return view('email.index');
    }
}
