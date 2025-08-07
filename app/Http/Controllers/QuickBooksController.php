<?php

namespace App\Http\Controllers;

use App\Models\Sales\SalesSetting;
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
       
        $realmId = SalesSetting::updateorCreate([
            'key' => 'quickbooks_realm_id',
        ], [
            'value' => $request->realmId,
        ]);

        $accessToken = SalesSetting::updateorCreate([
            'key' => 'quickbooks_access_token',
        ], [
            'value' => $accessToken->getAccessToken(),
        ]);

        $refreshToken = SalesSetting::updateorCreate([
            'key' => 'quickbooks_refresh_token',
        ], [
            'value' => $accessToken->getRefreshToken(),
        ]);
        
        return redirect()->route('sales.settings.index')->with('success', 'QuickBooks connected successfully.');
    }

    public function getCustomers()
    {
        $accessToken = SalesSetting::where('key', 'quickbooks_access_token')->value('value');
        $realmId = SalesSetting::where('key', 'quickbooks_realm_id')->value('value');

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
