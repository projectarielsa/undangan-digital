<?php

namespace App\Services;

use App\Models\Invitation;
use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    /**
     * Log visitor untuk invitation
     */
    public function logVisitor(Invitation $invitation, Request $request, ?int $guestId = null, string $page = 'main'): void
    {
        // Check if analytics is enabled for this invitation's package
        if (!$this->hasAnalyticsFeature($invitation)) {
            return;
        }

        $userAgent = $request->userAgent() ?? '';
        $deviceInfo = VisitorLog::parseUserAgent($userAgent);

        VisitorLog::create([
            'invitation_id' => $invitation->id,
            'guest_id' => $guestId,
            'ip_address' => $request->ip(),
            'user_agent' => substr($userAgent, 0, 255),
            'device_type' => $deviceInfo['device_type'],
            'browser' => $deviceInfo['browser'],
            'platform' => $deviceInfo['platform'],
            'referrer' => $request->header('referer') ? substr($request->header('referer'), 0, 255) : null,
            'page_visited' => $page,
        ]);
    }

    /**
     * Check apakah invitation memiliki fitur analytics
     */
    public function hasAnalyticsFeature(Invitation $invitation): bool
    {
        $subscription = $invitation->user->activeSubscription();
        if (!$subscription) {
            return false;
        }
        
        return $subscription->package->has_analytics ?? false;
    }

    /**
     * Get statistik ringkasan untuk invitation
     */
    public function getSummaryStats(Invitation $invitation): array
    {
        $logs = VisitorLog::forInvitation($invitation->id);
        
        return [
            'total_views' => $invitation->view_count,
            'unique_visitors' => (clone $logs)->distinct('ip_address')->count('ip_address'),
            'today_views' => (clone $logs)->today()->count(),
            'this_week_views' => (clone $logs)->thisWeek()->count(),
            'this_month_views' => (clone $logs)->thisMonth()->count(),
        ];
    }

    /**
     * Get statistik device breakdown
     */
    public function getDeviceStats(Invitation $invitation): array
    {
        return VisitorLog::forInvitation($invitation->id)
            ->select('device_type', DB::raw('COUNT(*) as count'))
            ->groupBy('device_type')
            ->pluck('count', 'device_type')
            ->toArray();
    }

    /**
     * Get statistik browser breakdown
     */
    public function getBrowserStats(Invitation $invitation): array
    {
        return VisitorLog::forInvitation($invitation->id)
            ->select('browser', DB::raw('COUNT(*) as count'))
            ->groupBy('browser')
            ->orderByDesc('count')
            ->limit(5)
            ->pluck('count', 'browser')
            ->toArray();
    }

    /**
     * Get statistik platform/OS breakdown
     */
    public function getPlatformStats(Invitation $invitation): array
    {
        return VisitorLog::forInvitation($invitation->id)
            ->select('platform', DB::raw('COUNT(*) as count'))
            ->groupBy('platform')
            ->orderByDesc('count')
            ->limit(5)
            ->pluck('count', 'platform')
            ->toArray();
    }

    /**
     * Get statistik referrer breakdown
     */
    public function getReferrerStats(Invitation $invitation): array
    {
        return VisitorLog::forInvitation($invitation->id)
            ->whereNotNull('referrer')
            ->select('referrer', DB::raw('COUNT(*) as count'))
            ->groupBy('referrer')
            ->orderByDesc('count')
            ->limit(10)
            ->pluck('count', 'referrer')
            ->toArray();
    }

    /**
     * Get statistik harian untuk chart (last 30 days)
     */
    public function getDailyStats(Invitation $invitation, int $days = 30): array
    {
        $startDate = now()->subDays($days)->startOfDay();
        
        $stats = VisitorLog::forInvitation($invitation->id)
            ->where('created_at', '>=', $startDate)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Fill in missing dates with 0
        $result = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $result[$date] = $stats[$date] ?? 0;
        }

        return $result;
    }

    /**
     * Get statistik per jam (untuk hari ini)
     */
    public function getHourlyStats(Invitation $invitation): array
    {
        $stats = VisitorLog::forInvitation($invitation->id)
            ->today()
            ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('COUNT(*) as count'))
            ->groupBy('hour')
            ->pluck('count', 'hour')
            ->toArray();

        // Fill all 24 hours
        $result = [];
        for ($i = 0; $i < 24; $i++) {
            $result[$i] = $stats[$i] ?? 0;
        }

        return $result;
    }

    /**
     * Get RSVP analytics chart data
     */
    public function getRsvpChartData(Invitation $invitation): array
    {
        $guests = $invitation->guests();
        
        return [
            'attending' => (clone $guests)->where('rsvp_status', 'attending')->count(),
            'not_attending' => (clone $guests)->where('rsvp_status', 'not_attending')->count(),
            'maybe' => (clone $guests)->where('rsvp_status', 'maybe')->count(),
            'pending' => (clone $guests)->where('rsvp_status', 'pending')->count(),
        ];
    }

    /**
     * Get total expected guests dari yang attending
     */
    public function getExpectedGuests(Invitation $invitation): int
    {
        return $invitation->guests()
            ->where('rsvp_status', 'attending')
            ->sum('number_of_guests');
    }

    /**
     * Get guest open rate
     */
    public function getGuestOpenRate(Invitation $invitation): array
    {
        $total = $invitation->guests()->count();
        $opened = $invitation->guests()->whereNotNull('opened_at')->count();
        
        return [
            'total' => $total,
            'opened' => $opened,
            'rate' => $total > 0 ? round(($opened / $total) * 100, 1) : 0,
        ];
    }
}
