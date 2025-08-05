<?php
namespace App\Helper;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class FirstServe
{
    public $env;
    public $baseURL;
    public $apiKey;
    public $apiSecret;

    public function __construct()
    {
        $this->env = env('FIRST_SERVE_ENV', 'production');
        if($this->env === 'sandbox') {
            $this->baseURL = env('FIRST_SERVE_SANDBOX_BASE_URL', 'https://api.sandbox.mysfsgateway.com/api/v2');
        } else {
            $this->baseURL = env('FIRST_SERVE_PRODUCTION_BASE_URL', 'https://api.mysfsgateway.com/api/v2');
        }
        
        $this->apiKey = env('FIRST_SERVE_API_KEY');
        $this->apiSecret = env('FIRST_SERVE_API_PIN');
    }

    public function createCustomer($customer)
    {
        $client = new Client();
        $response = $client->post($this->baseURL.'/customers', [
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
}