<?php

namespace App\Http\Controllers;

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

        $payload = $request->getContent();

        Log::info('Received FirstServe webhook event', [
            'data' => $payload
        ]);


        $this->processEvent($payload['event'], $payload['data'], $payload['id']);

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
                case 'payment.succeeded':
                    $this->handlePaymentSucceeded($data);
                    break;
                case 'payment.failed':
                    $this->handlePaymentFailed($data);
                    break;
                case 'invoice.paid':
                    $this->handleInvoicePaid($data);
                    break;
                case 'invoice.payment_failed':
                    $this->handleInvoicePaymentFailed($data);
                    break;
                case 'subscription.created':
                    $this->handleSubscriptionCreated($data);
                    break;
                case 'subscription.cancelled':
                    $this->handleSubscriptionCancelled($data);
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
        // Example data:
        // {
        //   "payment_id": "pay_123",
        //   "amount": 10000,
        //   "currency": "USD",
        //   "customer_id": "cus_123",
        //   "invoice_id": "inv_123",
        //   "created_at": "2023-06-15T12:00:00Z"
        // }

        $payment = Payment::updateOrCreate(
            ['gateway_id' => $data['payment_id']],
            [
                'amount' => $data['amount'] / 100, // Convert cents to dollars
                'currency' => $data['currency'],
                'customer_id' => $data['customer_id'],
                'invoice_id' => $data['invoice_id'],
                'status' => 'succeeded',
                'processed_at' => Carbon::parse($data['created_at'])
            ]
        );

        // Trigger any payment success actions
    }

    protected function handlePaymentFailed(array $data)
    {
        // Example data:
        // {
        //   "payment_id": "pay_123",
        //   "amount": 10000,
        //   "currency": "USD",
        //   "customer_id": "cus_123",
        //   "invoice_id": "inv_123",
        //   "failure_reason": "insufficient_funds",
        //   "created_at": "2023-06-15T12:00:00Z"
        // }

        $payment = Payment::updateOrCreate(
            ['gateway_id' => $data['payment_id']],
            [
                'amount' => $data['amount'] / 100,
                'currency' => $data['currency'],
                'customer_id' => $data['customer_id'],
                'invoice_id' => $data['invoice_id'],
                'status' => 'failed',
                'failure_reason' => $data['failure_reason'],
                'processed_at' => Carbon::parse($data['created_at'])
            ]
        );

        // Trigger payment failure actions
        event(new PaymentFailed($payment));
    }

    protected function handleInvoicePaid(array $data)
    {
        // Example data:
        // {
        //   "invoice_id": "inv_123",
        //   "amount_paid": 10000,
        //   "currency": "USD",
        //   "paid_at": "2023-06-15T12:00:00Z"
        // }

        $invoice = Invoice::where('gateway_id', $data['invoice_id'])->first();
        if ($invoice) {
            $invoice->update([
                'status' => 'paid',
                'paid_at' => Carbon::parse($data['paid_at']),
                'amount_paid' => $data['amount_paid'] / 100
            ]);

            // Trigger invoice paid actions
            event(new InvoicePaid($invoice));
        }
    }
}
