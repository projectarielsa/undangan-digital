<?php

use App\Models\Invitation;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Expire subscriptions that have passed their expires_at date
Schedule::call(function () {
    Subscription::where('status', 'active')
        ->where('expires_at', '<', now())
        ->update(['status' => 'expired']);

    // Pause invitations linked to expired subscriptions
    Invitation::where('status', 'published')
        ->whereHas('package', function ($q) {
            $q->whereDoesntHave('subscriptions', function ($sq) {
                $sq->where('status', 'active')->where('expires_at', '>', now());
            });
        })
        ->where('expires_at', '<', now())
        ->update(['status' => 'expired']);
})->daily()->at('02:00')->name('expire-subscriptions');

// Clean up pending payments older than 24 hours
Schedule::call(function () {
    Payment::where('status', 'pending')
        ->where('created_at', '<', now()->subHours(24))
        ->update(['status' => 'expired']);
})->hourly()->name('expire-pending-payments');
