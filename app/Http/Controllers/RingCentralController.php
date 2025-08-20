<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Delivery;

class RingCentralController extends Controller
{
    protected function tokenHeaders($user)
    {
        return [
            'Authorization' => 'Bearer ' . $user->rc_access_token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    public function callDeliveryContact($deliveryId)
    {
        $delivery = Delivery::findOrFail($deliveryId);
        $user = Auth::user();

        if (!$user->rc_access_token || !$delivery->contact_phone) {
            return back()->with('error', 'Missing RingCentral token or delivery contact.');
        }

        $url = env('RINGCENTRAL_SERVER_URL', 'https://platform.ringcentral.com') . '/restapi/v1.0/account/~/extension/~/ring-out';

        try {
            $response = Http::withHeaders($this->tokenHeaders($user))->post($url, [
                'from' => ['phoneNumber' => $user->rc_email],  // Assumes RC email is their caller ID
                'to' => ['phoneNumber' => $delivery->contact_phone],
                'playPrompt' => false,
            ]);

            if ($response->successful()) {
                return back()->with('success', 'Call initiated to ' . $delivery->contact_phone);
            }

            return back()->with('error', 'Call failed: ' . $response->body());

        } catch (\Exception $e) {
            return back()->with('error', 'Exception during call: ' . $e->getMessage());
        }
    }


    public function call($id)
    {
        return $this->callDeliveryContact($id);
    }


        
    public function connect()
    {
        $authUrl = 'https://platform.ringcentral.com/restapi/oauth/authorize' .
            '?response_type=code' .
            '&client_id=' . urlencode(env('RINGCENTRAL_CLIENT_ID')) .
            '&redirect_uri=' . urlencode(env('RINGCENTRAL_REDIRECT_URI')) .
            '&state=' . csrf_token();

        return redirect($authUrl);
    }

    public function callback(Request $request)
    {
        $response = Http::asForm()->post('https://platform.ringcentral.com/restapi/oauth/token', [
            'grant_type' => 'authorization_code',
            'code' => $request->code,
            'redirect_uri' => env('RINGCENTRAL_REDIRECT_URI'),
            'client_id' => env('RINGCENTRAL_CLIENT_ID'),
            'client_secret' => env('RINGCENTRAL_CLIENT_SECRET'),
        ]);

        if (!$response->successful()) {
            return back()->with('error', 'OAuth failed: ' . $response->body());
        }

        $token = $response->json();

        // Retrieve user from session
        $user = \App\Models\User::find(session('rc_user_id'));

        if (!$user) {
            return redirect()->route('login')->with('error', 'User session expired. Please log in again.');
        }

        // Optional: Get extension info
        $profile = Http::withToken($token['access_token'])
            ->get('https://platform.ringcentral.com/restapi/v1.0/account/~/extension/~')
            ->json();

        $user->update([
            'rc_access_token' => $token['access_token'],
            'rc_refresh_token' => $token['refresh_token'],
            'rc_token_expiry' => now()->addSeconds($token['expires_in']),
            'rc_extension_id' => $profile['id'] ?? null,
            'rc_email' => $profile['contact']['email'] ?? null,
        ]);

        return redirect()->route('dashboard')->with('success', 'RingCentral connected!');
    }

}
