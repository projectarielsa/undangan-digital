<?php
namespace App\Services;
use App\Models\Package;
use App\Models\Payment;
use App\Models\User;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }
    public function createTransaction(User $user, Package $package, ?int $invitationId = null): Payment
    {
        $orderId = 'INV-' . time() . '-' . $user->id;
        $amount = $package->getEffectivePrice();
        $payment = Payment::create(['user_id' => $user->id, 'invitation_id' => $invitationId, 'package_id' => $package->id, 'order_id' => $orderId, 'amount' => $package->price, 'discount_amount' => $package->discount_price ? $package->price - $package->discount_price : 0, 'total_amount' => $amount, 'status' => 'pending', 'expired_at' => now()->addHours(24)]);
        $params = ['transaction_details' => ['order_id' => $orderId, 'gross_amount' => (int) $amount], 'customer_details' => ['first_name' => $user->name, 'email' => $user->email], 'item_details' => [['id' => $package->slug, 'price' => (int) $amount, 'quantity' => 1, 'name' => 'Paket ' . $package->name]], 'callbacks' => ['finish' => route('customer.payments.finish')]];
        $snapToken = Snap::getSnapToken($params);
        $payment->update(['midtrans_snap_token' => $snapToken]);
        return $payment;
    }
    public function handleNotification(array $n): Payment
    {
        $payment = Payment::where('order_id', $n['order_id'])->firstOrFail();
        $status = $n['transaction_status'];
        if ($status === 'capture' || $status === 'settlement') { $payment->markAsPaid($n['transaction_id'] ?? '', $n['payment_type'] ?? '', $n); }
        elseif (in_array($status, ['deny', 'cancel'])) { $payment->update(['status' => 'failed', 'midtrans_response' => $n]); }
        elseif ($status === 'expire') { $payment->update(['status' => 'expired', 'midtrans_response' => $n]); }
        return $payment;
    }
}