<?php

namespace App\Http\Controllers;

use App\Models\Sales\Invoice;
use App\Models\Sales\InvoicePayment;
use App\Models\Sales\Quote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
         // Handle all incoming webhook events
    public function handle(Request $request)
    {
        // Verify the webhook signature first
        if (!$this->verifySignature($request)) {
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        // Process the event

        $payload = json_decode($request->getContent(), true);

        Log::info('Received FirstServe webhook event', [
            'data' => $payload
        ]);


        $this->processEvent($payload['type'], $payload['data'], $payload['id']);

        return response()->json(['status' => 'success']);
    }

    // Verify the HMAC signature
    protected function verifySignature(Request $request): bool
    {
        $signature = $request->header('X-Signature');
        Log::info('Verifying FirstServe webhook signature', [
            'signature' => $signature,
            'payload' => $request->getContent()
        ]);

        $payload = $request->getContent();
        $secret = config('services.firstserve.webhook_sandbox_secret');

        $expectedSignature = hash_hmac('sha256', $payload, $secret);

        if (!hash_equals($expectedSignature, $signature)) {
            Log::error('Invalid FirstServe webhook signature', [
                'expected' => $expectedSignature,
                'received' => $signature,
                'payload' => $payload
            ]);
            return false;
        }

        return true;
    }


    // Route events to appropriate handlers
    protected function processEvent( $eventType, $data, $eventId)
    {
        Log::info('Processing event:', [
            'event_type' => $eventType,
            'data' => $data,
            'event_id' => $eventId
        ]);

        try {
            switch ($eventType) {
                case 'succeeded':
                    $this->handlePaymentSucceeded($data);
                    break;
                case 'declined':
                    $this->handlePaymentFailed($data);
                    break;
                case 'error':
                    $this->handlePaymentError($data);
                    break;
                default:
                    Log::warning("Unhandled webhook event type", [
                        'event_type' => $eventType
                    ]);
            }

        } catch (\Exception $e) {
            Log::error("Error processing webhook event", [
                'event_type' => $eventType,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    // ===== Event Handlers ===== //

    protected function handlePaymentSucceeded(array $data)
    {
        $invoice = Invoice::where('invoice_number', $data['transaction']['transaction_details']['invoice_number'])->first();

        if($invoice) {
            $invoice->update([
                'status' => 'paid',
                'paid_amount' => $data['auth_amount'],
                'remaining_amount' => $invoice->total - $data['auth_amount'],
            ]);

            InvoicePayment::create([
                'invoice_id' => $invoice->id,
                'status' => 'completed',
                'payment_amount' => $data['transaction']['amount_details']['amount'],
                'gateway_response' => json_encode($data)
            ]);
        }
    }

    protected function handlePaymentFailed(array $data)
    {
        $invoice = Invoice::where('invoice_number', $data['transaction']['transaction_details']['invoice_number'])->first();

        if($invoice) {
            $invoice->update([
                'status' => 'declined',
                'paid_amount' => $data['auth_amount'],
                'remaining_amount' => $invoice->total - $data['auth_amount'],
            ]);

            InvoicePayment::create([
                'invoice_id' => $invoice->id,
                'status' => 'declined',
                'payment_amount' => $data['transaction']['amount_details']['amount'],
                'gateway_response' => json_encode($data)
            ]);
        }
    }

    public function handlePaymentError($data)
    {
        $invoice = Invoice::where('invoice_number', $data['transaction']['transaction_details']['invoice_number'])->first();

        if($invoice) {
            $invoice->update([
                'status' => 'error',
                'paid_amount' => $data['auth_amount'],
                'remaining_amount' => $invoice->total - $data['auth_amount'],
            ]);

            InvoicePayment::create([
                'invoice_id' => $invoice->id,
                'status' => 'error',
                'error_message' => $data['error_message'],
                'gateway_response' => json_encode($data)
            ]);
        }
    }

    public function handleIncomingSms(Request $request)
    {
        // Log the raw request for debugging
        Log::info('Incoming SMS Webhook:', $request->all());

        // RingCentral sends data as JSON
        $data = $request->json()->all();
        Log::info('Parsed Incoming SMS Data:', $data);
        // Extract the crucial information
        $fromNumber = $data['from']['phoneNumber'] ?? null;
        $messageText = trim($data['text'] ?? ''); // This will be "1" or "2"

        if (!$fromNumber || !$messageText) {
            Log::warning('Invalid webhook payload received.');
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        // 1. Find the quote that was sent to this phone number
        // You need a relationship between quotes and customers
        $quote = Quote::whereHas('customer', function ($query) use ($fromNumber) {
                $query->where('phone', $fromNumber);
            })
            ->where('status', 'sent_for_approval') // Only look for quotes awaiting approval
            ->latest() // Get the most recent one
            ->first();

        if (!$quote) {
            Log::warning('No pending quote found for phone number: ' . $fromNumber);
            // You could send an SMS back saying "Quote not found"
            return response()->json(['status' => 'quote_not_found']);
        }

        // 2. Process the response
        switch ($messageText) {
            case '1':
                $quote->update(['status' => 'approved']);
                $responseMessage = "Quote #{$quote->id} has been APPROVED. Thank you!";
                break;
            case '2':
                $quote->update(['status' => 'declined']);
                $responseMessage = "Quote #{$quote->id} has been DECLINED.";
                break;
            default:
                // If they send anything other than 1 or 2
                $responseMessage = "Invalid response. Please reply only with '1' to approve or '2' to decline.";
                break;
        }

        // 3. (Optional) Send a confirmation SMS back to the customer
        // You would use your RingCentralService here again to send $responseMessage

        Log::info("Processed SMS response for Quote #{$quote->id}. New status: {$quote->status}");

        // RingCentral expects a 200 OK response
        return response()->json(['status' => 'success']);
    }
}
