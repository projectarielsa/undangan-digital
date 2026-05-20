<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\InvitationView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function show(Invitation $invitation, Request $request)
    {
        $this->authorize('view', $invitation);
        
        // Check if user has analytics feature
        $package = $invitation->package;
        $hasAnalytics = $package && $package->has_analytics;
        
        if (!$hasAnalytics) {
            return view('customer.analytics.locked', compact('invitation'));
        }
        
        $period = $request->get('period', '7'); // days
        $startDate = now()->subDays((int)$period);
        
        // Basic stats
        $totalViews = $invitation->view_count;
        $periodViews = $invitation->views()->where('viewed_at', '>=', $startDate)->count();
        $uniqueVisitors = $invitation->views()->where('viewed_at', '>=', $startDate)->distinct('ip_address')->count('ip_address');
        
        // Views per day chart data
        $viewsPerDay = $invitation->views()
            ->where('viewed_at', '>=', $startDate)
            ->select(DB::raw('DATE(viewed_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();
        
        // Fill missing dates
        $chartData = [];
        for ($i = (int)$period - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartData[$date] = $viewsPerDay[$date] ?? 0;
        }
        
        // Device breakdown
        $deviceStats = $invitation->views()
            ->where('viewed_at', '>=', $startDate)
            ->select('device_type', DB::raw('COUNT(*) as count'))
            ->groupBy('device_type')
            ->get()
            ->pluck('count', 'device_type')
            ->toArray();
        
        // Browser breakdown
        $browserStats = $invitation->views()
            ->where('viewed_at', '>=', $startDate)
            ->select('browser', DB::raw('COUNT(*) as count'))
            ->groupBy('browser')
            ->orderByDesc('count')
            ->limit(5)
            ->get()
            ->pluck('count', 'browser')
            ->toArray();
        
        // RSVP stats
        $rsvpStats = $invitation->getRsvpStats();
        
        // Guest open rate
        $totalGuests = $invitation->guests()->count();
        $openedGuests = $invitation->guests()->whereNotNull('opened_at')->count();
        $openRate = $totalGuests > 0 ? round(($openedGuests / $totalGuests) * 100, 1) : 0;
        
        // Recent visitors
        $recentViews = $invitation->views()
            ->with('guest')
            ->latest('viewed_at')
            ->take(20)
            ->get();
        
        // Peak hours
        $peakHours = $invitation->views()
            ->where('viewed_at', '>=', $startDate)
            ->select(DB::raw('HOUR(viewed_at) as hour'), DB::raw('COUNT(*) as count'))
            ->groupBy('hour')
            ->orderByDesc('count')
            ->limit(5)
            ->get();
        
        return view('customer.analytics.show', compact(
            'invitation', 'totalViews', 'periodViews', 'uniqueVisitors',
            'chartData', 'deviceStats', 'browserStats', 'rsvpStats',
            'totalGuests', 'openedGuests', 'openRate', 'recentViews',
            'peakHours', 'period'
        ));
    }
}
