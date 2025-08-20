<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google_maps' => [
        'api_key' => env('AIzaSyCPhMXb_6VAGwwSMYj9S1udEO027E3BZT0'),
    ],

    'firstserve' => [
        'env' => env('FIRST_SERVE_ENV', 'sandbox'),
        'sandbox_base_url' => env('FIRST_SERVE_SANDBOX_BASE_URL', 'https://api.sandbox.mysfsgateway.com/api/v2'),
        'sandbox_api_key' => env('FIRST_SERVE_SANDBOX_API_KEY', 'FWTHFabOKw7DJVNSVvo3YS2ZwuWbQnUM'),
        'sandbox_api_pin' => env('FIRST_SERVE_SANDBOX_API_PIN', '1234'),
        'production_base_url' => env('FIRST_SERVE_PRODUCTION_BASE_URL', 'https://api.mysfsgateway.com/api/v2'),
        'production_api_key' => env('FIRST_SERVE_PRODUCTION_API_KEY', 'FJqTSiCkjkMkdnknbw4RwLMuSHuXc4Pd'),
        'production_api_pin' => env('FIRST_SERVE_PRODUCTION_API_PIN', '0129'),
        'webhook_sandbox_secret' => env('FIRST_SERVE_SANDBOX_SIGNATURE', 'JMkVGUiVXBkNQa6lYgmztRQFJbnGO6Zx'),
        "webhook_production_secret" => env('FIRST_SERVE_PRODUCTION_SIGNATURE', 'FJqTSiCkjkMkdnknbw4RwLMuSHuXc4Pd'),
    ],

    'ringcentral' => [
        'client_id' => env('RINGCENTRAL_CLIENT_ID'),
        'client_secret' => env('RINGCENTRAL_CLIENT_SECRET'),
        'server_url' => env('RINGCENTRAL_SERVER_URL'),
        'username' => env('RINGCENTRAL_USERNAME'),
        'password' => env('RINGCENTRAL_PASSWORD'),
        'extension' => env('RINGCENTRAL_EXTENSION'),
        'sms_from' => env('RINGCENTRAL_SMS_FROM'),
        'jwt_token' => env('RINGCENTRAL_JWT_TOKEN'),
    ],
];
