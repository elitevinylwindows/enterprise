<?php

namespace App\Services;

use QuickBooksOnline\API\DataService\DataService;

class QuickBooksService
{
    public static function initialize()
    {
        $dataService = DataService::Configure([
            'auth_mode'       => 'oauth2',
            'ClientID'        => env('QB_CLIENT_ID'),
            'ClientSecret'    => env('QB_CLIENT_SECRET'),
            'RedirectURI'     => env('QB_REDIRECT_URI'),
            'scope'           => 'com.intuit.quickbooks.accounting',
            'baseUrl'         => env('QB_ENVIRONMENT') === 'production' ? "Production" : "Development"
        ]);

        return $dataService;
    }
}
