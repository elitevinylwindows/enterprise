<?php

namespace App\Http\Controllers;

use App\Models\Sales\Invoice as SalesInvoice;
use App\Models\Sales\SalesSetting;
use App\Services\QuickBooksService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use QuickBooksOnline\API\Facades\Customer;
use QuickBooksOnline\API\Facades\Invoice;
use QuickBooksOnline\API\Facades\Item;

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

        // Refresh token
        $oauth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $newAccessToken = $oauth2LoginHelper->refreshAccessTokenWithRefreshToken($refreshToken);

        SalesSetting::updateOrCreate(['key' => 'quickbooks_access_token'], [
            'value' => $newAccessToken->getAccessToken(),
        ]);

        SalesSetting::updateOrCreate(['key' => 'quickbooks_refresh_token'], [
            'value' => $newAccessToken->getRefreshToken(),
        ]);

        $dataService->updateOAuth2Token($newAccessToken);

        $accounts = $dataService->Query("SELECT * FROM Account WHERE AccountType='Income'");
        dd($accounts);

        // Get or create customer
        $customerName = trim($invoice->customer->customer_name);
        $qboCustomer = $dataService->Query("SELECT * FROM Customer WHERE DisplayName = '{$customerName}'");

        if (!$qboCustomer || empty($qboCustomer)) {
            $qboCustomer = $dataService->Add(Customer::create([
                "DisplayName" => $invoice->customer->customer_name,
                "PrimaryEmailAddr" => [
                    "Address" => $invoice->customer->email,
                ],
            ]));
        } else {
            $qboCustomer = $qboCustomer[0];
        }

        // Create items if not exist
        $lineItems = [];

        foreach ($invoice->order->items as $orderItem) {
            $itemName = trim($orderItem->description);

            $qboItem = $dataService->Query("SELECT * FROM Item WHERE Name = '{$itemName}'");

            if (!$qboItem || empty($qboItem)) {
                // Create item
                $qboItem = $dataService->Add(Item::create([
                    "Name" => $itemName,
                    "Type" => "Service", // or "Inventory", "NonInventory"
                    "IncomeAccountRef" => [
                        "value" => "79", // Replace with your income account ID
                        "name" => "Sales of Product Income"
                    ],
                    "UnitPrice" => $orderItem->price,
                ]));
            } else {
                $qboItem = $qboItem[0];
            }

            $lineItems[] = [
                "Amount" => $orderItem->total,
                "DetailType" => "SalesItemLineDetail",
                "SalesItemLineDetail" => [
                    "ItemRef" => [
                        "value" => $qboItem->Id,
                        "name" => $qboItem->Name,
                    ],
                    "Qty" => $orderItem->qty,
                ],
                "Description" => $orderItem->description,
            ];
        }

        // Build and send invoice
        $invoiceData = [
            "CustomerRef" => [
                "value" => $qboCustomer->Id,
                "name" => $qboCustomer->DisplayName,
            ],
            "Line" => $lineItems,
        ];

        $qbInvoice = Invoice::create($invoiceData);
        $createdInvoice = $dataService->Add($qbInvoice);

        if ($error = $dataService->getLastError()) {
            Log::error('QuickBooks Error: ' . $error->getResponseBody());
            return back()->with('error', 'QuickBooks Error: ' . $error->getResponseBody());
        }

        return back()->with('success', 'Invoice sent to QuickBooks successfully!');
    }

}
