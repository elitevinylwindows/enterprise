<?php

namespace App\Http\Controllers;

use App\Services\QuickBooksService;
use Illuminate\Http\Request;

class QuickBooksController extends Controller
{
    public function connect()
    {
        $dataService = QuickBooksService::initialize();
        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();

        $authUrl = $OAuth2LoginHelper->getAuthorizationCodeURL();
        return redirect($authUrl);
    }

    public function callback(Request $request)
    {
        $dataService = QuickBooksService::initialize();
        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();

        $parseUrl = $request->fullUrl();

        $accessToken = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($request->code, $request->realmId);

        // Save token and realmId in session or database
        session([
            'quickbooks_access_token' => $accessToken->getAccessToken(),
            'quickbooks_refresh_token' => $accessToken->getRefreshToken(),
            'quickbooks_realm_id' => $request->realmId,
        ]);

        return redirect('/quickbooks/customers');
    }

    public function getCustomers()
    {
        $accessToken = session('quickbooks_access_token');
        $realmId = session('quickbooks_realm_id');

        if (!$accessToken || !$realmId) {
            return redirect('/quickbooks/connect');
        }

        $dataService = QuickBooksService::initialize();
        $dataService->updateOAuth2Token([
            'access_token' => $accessToken,
            'refresh_token' => session('quickbooks_refresh_token'),
        ]);
        $dataService->setRealmId($realmId);

        $customers = $dataService->Query("SELECT * FROM Customer");

        return view('quickbooks.customers', compact('customers'));
    }
}
