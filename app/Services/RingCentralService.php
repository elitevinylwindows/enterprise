<?php

namespace App\Services;

use RingCentral\SDK\SDK;

class RingCentralService
{
    protected $rc;

    public function __construct()
    {
        $this->rc = new SDK(
            env('RC_CLIENT_ID'),
            env('RC_CLIENT_SECRET'),
            env('RC_SERVER_URL'), // usually https://platform.ringcentral.com
            'Laravel App'
        );

        $this->platform = $this->rc->platform();

        $this->platform->login([
            'username' => env('RC_USERNAME'),     // RingCentral login
            'extension' => env('RC_EXTENSION'),   // optional
            'password' => env('RC_PASSWORD'),
        ]);
    }

    public function initiateCall($from, $to)
    {
        $response = $this->platform->post('/restapi/v1.0/account/~/extension/~/ring-out', [
            'from' => ['phoneNumber' => $from],
            'to' => ['phoneNumber' => $to],
            'playPrompt' => true
        ]);

        return $response->json();
    }
}
