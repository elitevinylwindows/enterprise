<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::error('webhook called');

        // Verify the webhook signature (if provided)
        $signature = $request->header('X-FirstServe-Signature');
        $payload = $request->getContent();
        
        if (!$this->verifySignature($signature, $payload)) {
            Log::error('Invalid webhook signature');
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        $event = $request->input('event');
        $data = $request->input('data');
        Log::info("Webhook event received: {$event}", $data);
        switch ($event) {
            case 'payment.created':
                $this->handlePaymentCreated($data);
                break;
            case 'invoice.paid':
                $this->handleInvoicePaid($data);
                break;
            case 'invoice.failed':
                $this->handlePaymentFailed($data);
                break;
            default:
                Log::info("Unhandled webhook event: {$event}");
        }

        return response()->json(['status' => 'success']);
    }

    protected function verifySignature($signature, $payload)
    {
        $secret = env('FIRST_SERVE_WEBHOOK_SIGNATURE');
        $computedSignature = hash_hmac('sha256', $payload, $secret);
        
        return hash_equals($signature, $computedSignature);
    }

    protected function handlePaymentCreated($data)
    {
        Log::info("Payment created: " . json_encode($data));
        // Update your system with payment info
    }

    protected function handleInvoicePaid($data)
    {
        Log::info("Invoice paid: " . json_encode($data));
        // Mark invoice as paid in your system
    }

    protected function handlePaymentFailed($data)
    {
        Log::warning("Payment failed: " . json_encode($data));
        // Update invoice status to failed
    }
}
