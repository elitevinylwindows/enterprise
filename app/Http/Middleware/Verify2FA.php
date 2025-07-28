<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class Verify2FA
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Not authenticated => no need to check
        if (!Auth::check()) {
            return $next($request);
        }

        // 2FA not enabled => no need to check
        if (is_null(Auth::user()->twofa_secret)) {
            return $next($request);
        }

        // 2FA is already checked
        if (session("2fa_checked", false)) {
            return $next($request);
        }

        // at this point user must provide a valid OTP
        // but we must avoid an infinite loop
        if (request()->is('login/otp')) {
            return $next($request);
        }

        return redirect()->route('otp.show');




    }
}
