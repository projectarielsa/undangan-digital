<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function __construct(protected AnalyticsService $analytics) {}

    public function show(Request $request, Invitation $invitation)
    {
        $this->authorize('view', $invitation);

        // Check if user has analytics feature
        if (!$invitation->hasAnalyticsFeature()) {
            return redirect()->route('customer.packages')
                ->with('error', 'Fitur Analytics hanya tersedia untuk paket Premium dan Exclusive. Silakan upgrade paket Anda.');
        }

        $stats = [
            'summary' => $this->analytics->getSummaryStats($invitation),
            'devices' => $this->analytics->getDeviceStats($invitation),
            'browsers' => $this->analytics->getBrowserStats($invitation),
            'platforms' => $this->analytics->getPlatformStats($invitation),
            'referrers' => $this->analytics->getReferrerStats($invitation),
            'rsvp' => $this->analytics->getRsvpChartData($invitation),
            'guest_open_rate' => $this->analytics->getGuestOpenRate($invitation),
            'expected_guests' => $this->analytics->getExpectedGuests($invitation),
        ];

        $dailyStats = $this->analytics->getDailyStats($invitation, 30);
        $hourlyStats = $this->analytics->getHourlyStats($invitation);

        return view('customer.invitations.analytics', compact('invitation', 'stats', 'dailyStats', 'hourlyStats'));
    }

    public function apiStats(Request $request, Invitation $invitation)
    {
        $this->authorize('view', $invitation);

        if (!$invitation->hasAnalyticsFeature()) {
            return response()->json(['error' => 'Feature not available'], 403);
        }

        $period = $request->input('period', 30);
        
        return response()->json([
            'summary' => $this->analytics->getSummaryStats($invitation),
            'daily' => $this->analytics->getDailyStats($invitation, $period),
            'devices' => $this->analytics->getDeviceStats($invitation),
            'rsvp' => $this->analytics->getRsvpChartData($invitation),
        ]);
    }
}
