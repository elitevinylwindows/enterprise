<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use PragmaRX\Google2FAQRCode\Google2FA;

class OTPController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // limit to 60 trials per minute, to avoid brute force
        $this->middleware('throttle:60,1');
    }

    public function show()
    {
        return view('auth.otp');
    }

    public function check(Request $request)
    {
        $google2fa = new Google2FA();
        $secret = Auth::user()->twofa_secret;
        if ($google2fa->verify($request->input('otp'), $secret)) {
            session(["2fa_checked" => true]);
            return redirect("/");
        }
        return redirect()->back()->with('error', __('Incorrect Code. Please try again...')); 
    }

    public function disable()
    {
        $user=\Auth::user();
        $user->twofa_secret=null;
        $user->save();
        return redirect()->back()->with('success', __('2 FA successfully disabled.'));
    }
}
