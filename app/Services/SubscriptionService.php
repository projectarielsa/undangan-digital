<?php
namespace App\Services;
use App\Models\Invitation;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;

class SubscriptionService
{
    public function activateFromPayment(Payment $payment): Subscription
    {
        $pkg = $payment->package;
        $sub = Subscription::create(['user_id' => $payment->user_id, 'package_id' => $pkg->id, 'payment_id' => $payment->id, 'invitation_id' => $payment->invitation_id, 'status' => 'active', 'starts_at' => now(), 'expires_at' => now()->addDays($pkg->duration_days)]);
        if ($payment->invitation_id) { $inv = Invitation::find($payment->invitation_id); if ($inv) { $inv->update(['package_id' => $pkg->id, 'expires_at' => $sub->expires_at]); if ($inv->isDraft()) $inv->publish(); } }
        return $sub;
    }
    public function getUserActivePackage(User $user): ?Package { return $user->activeSubscription()?->package; }
}