<?php

namespace App\Services;

use App\Models\Package;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    protected string $serverKey;

    public function __construct()
    {
        $this->serverKey = config('services.midtrans.server_key');
        
        Config::$serverKey = $this->serverKey;
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Create a new payment transaction with Midtrans Snap
     */
    public function createTransaction(User $user, Package $package, ?int $invitationId = null): Payment
    {
        $orderId = 'INV-' . time() . '-' . $user->id;
        $amount = $package->getEffectivePrice();

        $payment = Payment::create([
            'user_id' => $user->id,
            'invitation_id' => $invitationId,
            'package_id' => $package->id,
            'order_id' => $orderId,
            'amount' => $package->price,
            'discount_amount' => $package->discount_price ? $package->price - $package->discount_price : 0,
            'total_amount' => $amount,
            'status' => 'pending',
            'expired_at' => now()->addHours(24),
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => [[
                'id' => $package->slug,
                'price' => (int) $amount,
                'quantity' => 1,
                'name' => 'Paket ' . $package->name,
            ]],
            'callbacks' => [
                'finish' => route('customer.payments.finish'),
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        $payment->update(['midtrans_snap_token' => $snapToken]);

        return $payment;
    }

    /**
     * Verify Midtrans webhook signature
     * 
     * Signature formula: SHA512(order_id + status_code + gross_amount + server_key)
     * @see https://docs.midtrans.com/docs/https-notification-webhooks#verifying-notification-authenticity
     */
    public function verifySignature(array $notification): bool
    {
        $orderId = $notification['order_id'] ?? '';
        $statusCode = $notification['status_code'] ?? '';
        $grossAmount = $notification['gross_amount'] ?? '';
        $signatureKey = $notification['signature_key'] ?? '';

        if (empty($orderId) || empty($statusCode) || empty($grossAmount) || empty($signatureKey)) {
            Log::warning('Midtrans signature verification failed: missing required fields', [
                'order_id' => $orderId,
                'has_signature' => !empty($signatureKey),
            ]);
            return false;
        }

        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $this->serverKey);

        if (!hash_equals($expectedSignature, $signatureKey)) {
            Log::warning('Midtrans signature verification failed: signature mismatch', [
                'order_id' => $orderId,
            ]);
            return false;
        }

        return true;
    }

    /**
     * Handle Midtrans notification after signature verification
     */
    public function handleNotification(array $notification): Payment
    {
        $payment = Payment::where('order_id', $notification['order_id'])->firstOrFail();
        $status = $notification['transaction_status'];

        Log::info('Processing Midtrans notification', [
            'order_id' => $notification['order_id'],
            'status' => $status,
            'payment_type' => $notification['payment_type'] ?? 'unknown',
        ]);

        if ($status === 'capture' || $status === 'settlement') {
            $payment->markAsPaid(
                $notification['transaction_id'] ?? '',
                $notification['payment_type'] ?? '',
                $notification
            );
        } elseif (in_array($status, ['deny', 'cancel'])) {
            $payment->update([
                'status' => 'failed',
                'midtrans_response' => $notification,
            ]);
        } elseif ($status === 'expire') {
            $payment->update([
                'status' => 'expired',
                'midtrans_response' => $notification,
            ]);
        } elseif ($status === 'pending') {
            $payment->update([
                'midtrans_response' => $notification,
            ]);
        }

        return $payment;
    }
}