<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RingCentral\SDK\SDK;

class RingCentralService
{
    protected $sdk;
    protected $platform;

    public function __construct()
    {
        $this->sdk = new SDK(
            config('services.ringcentral.client_id'),
            config('services.ringcentral.client_secret'),
            config('services.ringcentral.server_url')
        );
        $this->platform = $this->sdk->platform();

        // Try to auto-login if we have a stored token, otherwise login with password
        // For production, you should implement token storage and refresh logic.
        try {
            $this->platform->login( [ "jwt" => config('services.ringcentral.jwt_token') ] );
        } catch (\Exception $e) {
            dd($e);
           $this->platform->login( [ "jwt" => config('services.ringcentral.jwt_token') ] );
        }
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

    public function sendQuoteApprovalSms(string $toPhoneNumber, string $quoteId, string $customerName, $pdfPath): array
    {
        $fullPath = Storage::disk('public')->path($pdfPath);

        $message = "Dear $customerName, your Quote from Elite Vinyl Windows is ready #$quoteId.\n";
        $message .= "Please click the link below to view:\n";
        $message .= "PDF: " . $fullPath . "\n";
        $message .= "Reply with;\n";
        $message .= "1 to Approve the Quote\n";
        $message .= "2 to Decline the Quote\n";
        $message .= "3 to Request for Modification\n";

        try {
            $response = $this->platform->post('/account/~/extension/~/sms', [
                'from' => ['phoneNumber' => config('services.ringcentral.sms_from')],
                'to'   => [['phoneNumber' => $toPhoneNumber]], // Format: +1234567890
                'text' => $message
            ]);

            return ['success' => true, 'data' => $response->json()];

        } catch (\RingCentral\SDK\Http\ApiException $e) {
            dd($e);
            Log::error('RingCentral SMS Failed: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function getSmsEnabledNumbers()
    {
        try {
            $endpoint = '/restapi/v1.0/account/~/extension/~/phone-number?perPage=100';
            $response = $this->platform->get($endpoint);
            $data = $response->json();
            $smsNumbers = [];
            
            foreach ($data->records as $number) {
                // Check if this number has SMS sending capability
                if (in_array('SmsSender', $number->features ?? [])) {
                    $smsNumbers[] = [
                        'phoneNumber' => $number->phoneNumber,
                        'type' => $number->type,
                        'usageType' => $number->usageType,
                        'features' => $number->features
                    ];
                }
            }
            return $smsNumbers;
            
        } catch (\Exception $e) {
        dd($e);
            \Log::error('Failed to get SMS numbers: ' . $e->getMessage());
            return [];
        }
    }
}
