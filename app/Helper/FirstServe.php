<?php
namespace App\Helper;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class FirstServe
{
    public $env;
    public $baseURL;
    public $apiKey;
    public $apiSecret;
    public $client;

    public function __construct()
    {
        $this->env = env('FIRST_SERVE_ENV', 'production');
        if($this->env === 'sandbox') {
            $this->baseURL = env('FIRST_SERVE_SANDBOX_BASE_URL', 'https://api.sandbox.mysfsgateway.com/api/v2');
            $this->apiKey = env('FIRST_SERVE_SANDBOX_API_KEY');
            $this->apiSecret = env('FIRST_SERVE_SANDBOX_API_PIN');
        } else {
            $this->baseURL = env('FIRST_SERVE_PRODUCTION_BASE_URL', 'https://api.mysfsgateway.com/api/v2');
            $this->apiKey = env('FIRST_SERVE_PRODUCTION_API_KEY');
            $this->apiSecret = env('FIRST_SERVE_PRODUCTION_API_PIN');
        }

        $this->client = new Client();
    }

    public function createCustomer($customer)
    {
        $response = $this->client->post($this->baseURL.'/customers', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->apiKey . ':' . $this->apiSecret),
            ],
            'json' => [
                'identifier' => $customer->customer_name,
                'customer_number' => $customer->customer_number,
                'email' => $customer->email,
                'phone' => $customer->billing_phone ?: "",
                'billing_info' => [
                    // Fill in address fields as required
                    'address_line1' => $customer->billing_address,
                    'city' => $customer->billing_city ?: "",
                    'state' => $customer->billing_state ?: "",
                    'postal_code' => $customer->billing_zip ?: "",
                    'country' => $customer->billing_country ?: ""
                ],
                'shipping_info' => [
                    // Fill in address fields as required
                    'address_line1' => $customer->delivery_address ?: "",
                    'city' => $customer->delivery_city ?: "",
                    'state' => $customer->delivery_state ?: "",
                    'postal_code' => $customer->delivery_zip ?: "",
                    'country' => $customer->delivery_country ?: ""
                ],
                'active' => true
            ]
        ]);

        $customer = $response->getBody()->getContents();

        return json_decode($customer, true);
    }

    public function updateCustomer($customer)
    {
        $response = $this->client->patch($this->baseURL.'/customers/'.$customer->serve_customer_id, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->apiKey . ':' . $this->apiSecret),
            ],
            'json' => [
                'identifier' => $customer->customer_name,
                'customer_number' => $customer->customer_number,
                'email' => $customer->email,
                'phone' => $customer->billing_phone ?: "",
                'billing_info' => [
                    // Fill in address fields as required
                    'street' => $customer->billing_address,
                    'city' => $customer->billing_city ?: "",
                    'state' => $customer->billing_state ?: "",
                    'postal_code' => $customer->billing_zip ?: "",
                    'country' => $customer->billing_country ?: ""
                ],
                'shipping_info' => [
                    // Fill in address fields as required
                    'street' => $customer->delivery_address ?: "",
                    'city' => $customer->delivery_city ?: "",
                    'state' => $customer->delivery_state ?: "",
                    'postal_code' => $customer->delivery_zip ?: "",
                    'country' => $customer->delivery_country ?: ""
                ],
                'active' => true
            ]
        ]);

        $customer = $response->getBody()->getContents();

        return json_decode($customer, true);
    }

    public function createInvoice($invoice)
    {
        $customerID = (int) $invoice->customer?->serve_customer_id ?: null;

        if ($customerID === null) {
            // If customer does not exist in FirstServe, create it
            $firstServeCustomer = $this->createCustomer($invoice->customer);
            if (isset($firstServeCustomer['id'])) {
                $customerID = (int) $firstServeCustomer['id'];
            } else {
                Log::error("Failed to create customer in FirstServe: " . json_encode($firstServeCustomer));
            }
        }

        $invoice->customer->serve_customer_id = $customerID;
        $invoice->customer->save();

        $response = $this->client->post($this->baseURL.'/invoices', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->apiKey . ':' . $this->apiSecret),
            ],
            'json' => [
                'customer_id' => $customerID,
                'date' => (string) date('Y-m-d'),
                'number' => generateInvoiceNumber(),
                'due_date' => (string) $invoice->due_date ?: null,
                'action' => 'charge',
                'requirement' => [
                    'value' => $invoice->remaining_amount ?: 0.0,
                    'type' => 'amount'
                ],
                'discount' => [
                    'value' => round((float) $invoice->discount ?: 0, 2),
                    'type' => 'amount'
                ],

                'shipping' => [
                    'value' => round((float) $invoice->shipping ?: 0, 2),
                    'type' => 'amount'
                ],

                'products' => $invoice->order->items->map(function ($item) use ($invoice) {
                    // Calculate per-item tax percentage
                    $itemPrice = round($item->price);
                    $totalItems = $invoice->order->items->count();
                    $perItemTaxAmount = $totalItems > 0 ? ((float) $invoice->tax / $totalItems) : 0.0;
                    $taxPercent = $itemPrice > 0 ? ($perItemTaxAmount / $itemPrice) * 100 : 0.0;

                    return [
                        'name' => $item->description,
                        'description' => $item->description,
                        'price' => $itemPrice,
                        'quantity' => (float) $item->qty,
                        'tax' => round($taxPercent, 2),
                    ];
                })->toArray(),
            ]
        ]);

        $invoice = $response->getBody()->getContents();
        Log::info("Invoice Created: " . $invoice);
        return json_decode($invoice, true);
    }

    public function updateInvoiceAmounts($invoice)
    {
        $response = $this->client->patch($this->baseURL.'/invoices/'.$invoice->serve_invoice_id, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->apiKey . ':' . $this->apiSecret),
            ],
            'json' => [
                'requirement' => [
                    'value' => $invoice->required_payment_type === 'percentage' ? (float) $invoice->required_payment_percentage : (float) $invoice->required_payment,
                    'type' => $invoice->required_payment_type === 'percentage' ? 'percent' : 'amount'
                ],
                'discount' => [
                    'value' => round((float) $invoice->discount ?: 0, 2),
                    'type' => 'amount'
                ],
                'shipping' => [
                    'value' => round((float) $invoice->shipping ?: 0, 2),
                    'type' => 'amount'
                ],
                'due_date' => (string) $invoice->due_date ?: null,
            ]
        ]);

        $invoice = $response->getBody()->getContents();
        Log::info("Invoice Updated: " . $invoice);
        return json_decode($invoice, true);
    }
}
