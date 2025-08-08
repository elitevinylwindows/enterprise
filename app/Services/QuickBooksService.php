<?php

namespace App\Services;

use App\Models\Sales\SalesSetting;
use QuickBooksOnline\API\DataService\DataService;

class QuickBooksService
{
    public static function initialize()
    {

        $accessToken = SalesSetting::where('key', 'quickbooks_access_token')->value('value');
        $refreshToken = SalesSetting::where('key', 'quickbooks_refresh_token')->value('value');
        $realmId = SalesSetting::where('key', 'quickbooks_realm_id')->value('value');


        $dataService = DataService::Configure([
            'auth_mode'       => 'oauth2',
            'ClientID'        => env('QB_CLIENT_ID'),
            'ClientSecret'    => env('QB_CLIENT_SECRET'),
            'RedirectURI'     => env('QB_REDIRECT_URI'),
            'scope'           => 'com.intuit.quickbooks.accounting',
             'accessTokenKey' => $accessToken,
            'refreshTokenKey' => $refreshToken,
            'QBORealmID' => $realmId, // ✅ VERY IMPORTANT
            'baseUrl'         => env('QB_ENVIRONMENT') === 'production' ? "Production" : "Development"
        ]);

        return $dataService;
    }

    public function generateInvoiceQBXML(array $data) { /* ... */ }

}
