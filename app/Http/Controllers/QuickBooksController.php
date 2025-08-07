<?php

namespace App\Http\Controllers;

use App\Models\Sales\Invoice as SalesInvoice;
use App\Models\Sales\SalesSetting;
use App\Services\QuickBooksService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use QuickBooksOnline\API\Facades\Customer;
use QuickBooksOnline\API\Facades\Invoice;

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

        SalesSetting::updateorCreate([
            'key' => 'quickbooks_realm_id',
        ], [
            'value' => $request->realmId,
        ]);

        SalesSetting::updateorCreate([
            'key' => 'quickbooks_access_token',
        ], [
            'value' => $accessToken->getAccessToken(),
        ]);

        SalesSetting::updateorCreate([
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

    public function sendInvoiceToQuickBooks($invoiceID)
    {
        $invoice = SalesInvoice::with(['customer', 'order.items'])->findOrFail($invoiceID);

        $accessToken = SalesSetting::where('key', 'quickbooks_access_token')->value('value');
        $refreshToken = SalesSetting::where('key', 'quickbooks_refresh_token')->value('value');
        $realmId = SalesSetting::where('key', 'quickbooks_realm_id')->value('value');

        if (!$accessToken || !$realmId || !$refreshToken) {
            return redirect('/quickbooks/connect');
        }

        $dataService = QuickBooksService::initialize();

        // Refresh token logic (optional, but good practice)
        $oauth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $newAccessToken = $oauth2LoginHelper->refreshAccessTokenWithRefreshToken($refreshToken);

        SalesSetting::updateOrCreate(['key' => 'quickbooks_access_token'], [
            'value' => $newAccessToken->getAccessToken(),
        ]);

        SalesSetting::updateOrCreate(['key' => 'quickbooks_refresh_token'], [
            'value' => $newAccessToken->getRefreshToken(),
        ]);

        $dataService->updateOAuth2Token($newAccessToken);

        // Get or create a customer in QuickBooks
        $qboCustomers = $dataService->Query("SELECT * FROM Customer");
        Log::info('List of Customers', ['customers' => $qboCustomers]);

       $customerName = trim($invoice->customer->customer_name);
        Log::info('Customer Name Being Queried', ['name' => $customerName]);

        $qboCustomer = $dataService->Query("SELECT * FROM Customer WHERE DisplayName = '{$customerName}'");

        if (!$qboCustomer || empty($qboCustomer)) {
            Log::info('Customer not found in QBO. Creating new customer.');

            $qboCustomer = $dataService->Add(Customer::create([
                "DisplayName" => $invoice->customer->customer_name,
                "PrimaryEmailAddr" => [
                    "Address" => $invoice->customer->email
                ],
            ]))->getCustomer();

            Log::info('New Customer Created in QBO', ['customer' => $qboCustomer]);
        } else {
            $qboCustomer = $qboCustomer[0];
            Log::info('Customer Found in QBO', ['customer' => $qboCustomer]);
        }

        $lineItems = [];

        // Create Invoice
        $invoiceData = [
            "CustomerRef" => [
                "value" => $qboCustomer->Id
            ]
        ];

        Log::info('QuickBooks Customer Query Result C: ', ['result' => $qboCustomer]);

        // Build line items array
        foreach ($invoice->order->items as $item) {
            $lineItems[] = [
                "Amount" => $item->total, // or $item->price * $item->quantity
                "DetailType" => "SalesItemLineDetail",
                "SalesItemLineDetail" => [
                    "ItemRef" => [
                        "value" => 0, // Use item's QuickBooks ID or fallback
                        "name" => $item->description,
                    ],
                    "Qty" => $item->qty,
                ],
                "Description" => $item->description,
            ];
        }

        $invoiceData = [
            "CustomerRef" => [
                "value" => $qboCustomer->Id
            ],
            "Line" => $lineItems,
        ];
        Log::info('QuickBooks Invoice Data Result C: ', ['result' => $invoiceData]);

        $invoice = Invoice::create($invoiceData);

        $dataService->Add($invoice);

        if ($error = $dataService->getLastError()) {
            Log::error('QuickBooks Error: ' . $error->getResponseBody());
            return back()->with('error', 'QuickBooks Error: ' . $error->getResponseBody());
        }

        return back()->with('success', 'Invoice sent to QuickBooks successfully!');
    }

}
