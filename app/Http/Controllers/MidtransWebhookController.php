<?php

namespace App\Http\Controllers;

use App\Services\MidtransService;
use App\Services\SubscriptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function __construct(
        protected MidtransService $midtrans,
        protected SubscriptionService $subscriptionService
    ) {}

    /**
     * Handle incoming Midtrans webhook notification
     * 
     * This endpoint receives payment status updates from Midtrans.
     * Security: Signature verification is mandatory to prevent fake notifications.
     */
    public function handle(Request $request): JsonResponse
    {
        $notification = $request->all();

        // Log incoming webhook for debugging
        Log::info('Midtrans webhook received', [
            'order_id' => $notification['order_id'] ?? 'unknown',
            'transaction_status' => $notification['transaction_status'] ?? 'unknown',
            'ip' => $request->ip(),
        ]);

        // Verify signature to ensure request comes from Midtrans
        if (!$this->midtrans->verifySignature($notification)) {
            Log::warning('Midtrans webhook rejected: invalid signature', [
                'order_id' => $notification['order_id'] ?? 'unknown',
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Invalid signature',
            ], 403);
        }

        try {
            $payment = $this->midtrans->handleNotification($notification);

            // Activate subscription if payment is successful
            if ($payment->isPaid()) {
                $this->subscriptionService->activateFromPayment($payment);
                
                Log::info('Subscription activated from payment', [
                    'order_id' => $payment->order_id,
                    'user_id' => $payment->user_id,
                    'package_id' => $payment->package_id,
                ]);
            }

            return response()->json(['status' => 'success']);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Midtrans webhook: Payment not found', [
                'order_id' => $notification['order_id'] ?? 'unknown',
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Payment not found',
            ], 404);

        } catch (\Exception $e) {
            Log::error('Midtrans webhook processing failed', [
                'order_id' => $notification['order_id'] ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Internal server error',
            ], 500);
        }
    }
}