<?php

namespace App\Http\Controllers;

use App\Models\Sales\Invoice;
use App\Models\Sales\InvoicePayment;
use App\Models\Sales\Quote;
use App\Services\RingCentralService;
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
         // Check if it's a validation request
        if ($request->hasHeader('Validation-Token')) {
            $token = $request->header('Validation-Token');
            Log::info("RingCentral validation token received: $token");

            // Respond with the same token in the header
            return response('', 200)
                ->header('Validation-Token', $token);
        }

        $payload = $request->all();
        Log::info('RingCentral webhook event:', $payload);

        if (isset($payload['body']['changes'])) {
            foreach ($payload['body']['changes'] as $change) {
                if ($change['type'] === 'SMS' && !empty($change['newMessageIds'])) {
                    foreach ($change['newMessageIds'] as $messageId) {
                        $ringCentralService = new RingCentralService();
                        // fetch full SMS message from RingCentral
                        $messageData = $ringCentralService->getSmsMessage($messageId);

                        Log::info("Received SMS Message: ". json_encode($messageData));

                        $conversationData = $ringCentralService->getConversation($messageData->conversation->id ?? '');

                        if (!empty($conversationData)) {
                            // Latest inbound message (first one)
                            $latest = $conversationData[0];

                            $messageId   = $latest->id;
                            $from        = $latest->from->phoneNumber ?? 'Unknown';
                            $text        = trim($latest->subject ?? '');
                            $createdAt   = $latest->creationTime;

                            Log::info("Latest inbound reply from {$from} at {$createdAt}: {$text}");

                            // Handle commands
                            switch ($text) {
                                case '1':
                                    Log::info("Received Quote Approval command from {$from}");

                                    Quote::where('ringcentral_message_id', $messageId)
                                        ->update(['status' => 'approved']);

                                    break;
                                case '2':
                                    Log::info("Received Quote Decline command from {$from}");
                                    Quote::where('ringcentral_message_id', $messageId)
                                    ->update(['status' => 'declined']);
                                    break;
                                case '3':
                                    Log::info("Received Quote Modification request from {$from}");
                                    Quote::where('ringcentral_message_id', $messageId)
                                        ->update(['status' => 'modification_requested']);
                                    break;
                                default:
                                    // Unknown command
                                    Log::info("Received Unknown command from {$from}");
                                    break;
                            }
                        }
                    }
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
