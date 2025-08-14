<?php
namespace App\Helper;

use App\Models\Master\Prices\TaxCode;
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
        // Validate and get customer ID
        $customerID = (int) $invoice->customer?->serve_customer_id ?: null;

        if ($customerID === null) {
            $firstServeCustomer = $this->createCustomer($invoice->customer);
            if (isset($firstServeCustomer['id'])) {
                $customerID = (int) $firstServeCustomer['id'];
                $invoice->customer->serve_customer_id = $customerID;
                $invoice->customer->save();
            } else {
                Log::error("Failed to create customer in FirstServe: " . json_encode($firstServeCustomer));
                throw new \Exception("Failed to create customer in FirstServe");
            }
        }

        $taxCode = TaxCode::where('city', $invoice->customer->billing_city)->first();

        if ($taxCode) {
            $taxRate = $taxCode->rate;
        } else
        {
            $taxRate = 0; // Default tax rate if no code found
        }

        // Calculate amounts
        $subtotal = (float) $invoice->sub_total; // $428.96
        $discount = (float) $invoice->discount; // -$1.04
        $shipping = (float) $invoice->shipping; // $12.00
        $tax = (float) $invoice->order->tax; // $39.71
        $total = (float) $invoice->total; // $468.67


        // Calculate shipping per item (distribute evenly)
        $itemCount = count($invoice->order->items);
        $shippingPerItem = $itemCount > 0 ? $shipping / $itemCount : 0;

        // Prepare products with item-level taxes and shipping
        $products = $invoice->order->items->map(function ($item) use ($taxRate, $shippingPerItem) {
            $itemPrice = (float) $item->price;
            $itemQuantity = (float) $item->qty;

            return [
                'name' => substr($item->description ?? 'Product', 0, 255),
                'description' => substr($item->glass ?? '', 0, 255),
                'price' => $itemPrice + $shippingPerItem, // Include shipping in price
                'quantity' => $itemQuantity,
                'tax' => (float)$taxRate // Apply tax rate to each item
            ];
        })->toArray();
        // Prepare invoice data
        $invoiceData = [
            'customer_id' => $customerID,
            'date' => now()->format('Y-m-d'),
            'number' => $invoice->invoice_number,
            'due_date' => $invoice->due_date ? $invoice->due_date : null,
            'action' => 'charge',
            'requirement' => [
                'value' => $total, // $468.67
                'type' => 'amount'
            ],
            'discount' => [
                'value' => abs($discount), // 1.04 (positive value)
                'type' => 'amount'
            ],
            'products' => $products,
            'note' => "Subtotal: $" . number_format($subtotal, 2) . "\n" .
                    "Discount: -$" . number_format(abs($discount), 2) . "\n" .
                    "Shipping: $" . number_format($shipping, 2) . "\n" .
                    "Tax: $" . number_format($tax, 2) . "\n" .
                    "Total: $" . number_format($total, 2),
        ];


        try {
            $response = $this->client->post($this->baseURL.'/invoices', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode($this->apiKey . ':' . $this->apiSecret),
                ],
                'json' => $invoiceData
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);

            if (isset($responseData['id'])) {
                $invoice->serve_invoice_id = $responseData['id'];
                $invoice->save();
                Log::info("Invoice #{$invoice->invoice_number} created successfully in FirstServe with amount due: $" . $total);
                return $responseData;
            } else {
                Log::error("Invoice creation failed: " . json_encode($responseData));
                throw new \Exception("Invoice creation failed: " . ($responseData['message'] ?? 'Unknown error'));
            }
        } catch (\Exception $e) {
            Log::error("Invoice API Error: " . $e->getMessage());
            throw $e;
        }
    }

    public function updateInvoiceAmounts($invoice, $amount)
    {
        $response = $this->client->patch($this->baseURL.'/invoices/'.$invoice->serve_invoice_id, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->apiKey . ':' . $this->apiSecret),
            ],
            'json' => [
                'requirement' => [
                    'value' => (float) $amount,
                    'type' => 'amount'
                ],
            ]
        ]);

        $invoice = $response->getBody()->getContents();
        Log::info("Invoice Updated: " . $invoice);
        return json_decode($invoice, true);
    }


    public function createPaymentMethod($customer, $cardDetails = [])
    {
        $response = $this->client->post($this->baseURL.'/customers/'.$customer->serve_customer_id.'/payment-methods', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->apiKey . ':' . $this->apiSecret),
            ],
            'json' => [
                "card" => $cardDetails['card'] ?? "string",
                "expiry_month" => $cardDetails['expiry_month'] ?? 1,
                "expiry_year" => $cardDetails['expiry_year'] ?? 2020,
            ]
        ]);

        $paymentMethod = $response->getBody()->getContents();
        Log::info("Payment Method Created: " . $paymentMethod);
        return json_decode($paymentMethod, true);
        
    }

    public function getPaymentMethods($customer)
    {
        $response = $this->client->get($this->baseURL.'/customers/'.$customer->serve_customer_id.'/payment-methods', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->apiKey . ':' . $this->apiSecret),
            ],
        ]);

        $paymentMethod = $response->getBody()->getContents();
        Log::info("Payment Methods: " . $paymentMethod);
        return json_decode($paymentMethod, true);
    }

    public function chargeCard($customer, $amount, $paymentMethodId, $invoiceId = null, $orderId = null)
    {
        $response = $this->client->post($this->baseURL.'/transactions/charge', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->apiKey . ':' . $this->apiSecret),
            ],
            'json' => [
                'amount' => (float)$amount,
                'source' =>'pm-'.$paymentMethodId,
                'save_card' => true,
                'charge' => true,
                'customer' => [
                    'customer_id' =>(int) $customer->serve_customer_id
                ],
                'transaction_details' => [
                    'invoice_number' => $invoiceId,
                ]
            ]
        ]);

        $charge = $response->getBody()->getContents();
        Log::info("Card Charged: " . $charge);
        return json_decode($charge, true);
    }
}
