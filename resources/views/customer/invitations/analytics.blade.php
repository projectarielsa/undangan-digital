@extends('layouts.dashboard')
@section('page-title', 'Analytics')
@section('sidebar-nav')<x-customer-nav />@endsection

@section('content')
<div class="max-w-6xl">
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('customer.invitations.edit', $invitation) }}" class="text-sm text-gray-500 hover:text-amber-600 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Edit
        </a>
        <span class="px-3 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-700">Premium Feature</span>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['summary']['total_views']) }}</p>
                    <p class="text-xs text-gray-500">Total Views</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['summary']['unique_visitors']) }}</p>
                    <p class="text-xs text-gray-500">Unique Visitors</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['summary']['today_views']) }}</p>
                    <p class="text-xs text-gray-500">Hari Ini</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['summary']['this_month_views']) }}</p>
                    <p class="text-xs text-gray-500">Bulan Ini</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6 mb-6">
        <!-- Daily Views Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Pengunjung 30 Hari Terakhir</h3>
            <div class="h-64">
                <canvas id="dailyChart"></canvas>
            </div>
        </div>

        <!-- RSVP Stats -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Statistik RSVP</h3>
            <div class="h-64 flex items-center justify-center">
                <canvas id="rsvpChart"></canvas>
            </div>
            <div class="mt-4 grid grid-cols-2 gap-2 text-sm">
                <div class="flex items-center gap-2"><span class="w-3 h-3 bg-green-500 rounded-full"></span> Hadir: {{ $stats['rsvp']['attending'] }}</div>
                <div class="flex items-center gap-2"><span class="w-3 h-3 bg-red-500 rounded-full"></span> Tidak Hadir: {{ $stats['rsvp']['not_attending'] }}</div>
                <div class="flex items-center gap-2"><span class="w-3 h-3 bg-yellow-500 rounded-full"></span> Ragu-ragu: {{ $stats['rsvp']['maybe'] }}</div>
                <div class="flex items-center gap-2"><span class="w-3 h-3 bg-gray-400 rounded-full"></span> Pending: {{ $stats['rsvp']['pending'] }}</div>
            </div>
            <div class="mt-4 p-3 bg-green-50 dark:bg-green-900/20 rounded-xl">
                <p class="text-sm text-green-700 dark:text-green-300 font-medium">
                    Estimasi Tamu Hadir: <span class="text-lg">{{ $stats['expected_guests'] }}</span> orang
                </p>
            </div>
        </div>
    </div>

    <div class="grid md:grid-cols-3 gap-6 mb-6">
        <!-- Device Stats -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Perangkat</h3>
            @php
                $deviceColors = ['mobile' => 'bg-blue-500', 'desktop' => 'bg-green-500', 'tablet' => 'bg-purple-500'];
                $deviceLabels = ['mobile' => 'Mobile', 'desktop' => 'Desktop', 'tablet' => 'Tablet'];
                $totalDevices = array_sum($stats['devices']) ?: 1;
            @endphp
            <div class="space-y-3">
                @forelse($stats['devices'] as $device => $count)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600 dark:text-gray-400">{{ $deviceLabels[$device] ?? ucfirst($device) }}</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ number_format($count) }}</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="{{ $deviceColors[$device] ?? 'bg-gray-500' }} h-2 rounded-full" style="width: {{ ($count / $totalDevices) * 100 }}%"></div>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-sm">Belum ada data</p>
                @endforelse
            </div>
        </div>

        <!-- Browser Stats -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Browser</h3>
            @php $totalBrowsers = array_sum($stats['browsers']) ?: 1; @endphp
            <div class="space-y-3">
                @forelse($stats['browsers'] as $browser => $count)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600 dark:text-gray-400">{{ $browser }}</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ number_format($count) }}</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-amber-500 h-2 rounded-full" style="width: {{ ($count / $totalBrowsers) * 100 }}%"></div>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-sm">Belum ada data</p>
                @endforelse
            </div>
        </div>

        <!-- Guest Open Rate -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Open Rate Undangan</h3>
            <div class="text-center py-4">
                <div class="relative w-32 h-32 mx-auto">
                    <svg class="w-32 h-32 transform -rotate-90" viewBox="0 0 120 120">
                        <circle cx="60" cy="60" r="50" fill="none" stroke="#e5e7eb" stroke-width="12"/>
                        <circle cx="60" cy="60" r="50" fill="none" stroke="#f59e0b" stroke-width="12" stroke-dasharray="{{ $stats['guest_open_rate']['rate'] * 3.14 }} 314" stroke-linecap="round"/>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['guest_open_rate']['rate'] }}%</span>
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-4">{{ $stats['guest_open_rate']['opened'] }} dari {{ $stats['guest_open_rate']['total'] }} tamu telah membuka undangan</p>
            </div>
        </div>
    </div>

    <!-- Referrer Stats -->
    @if(count($stats['referrers']) > 0)
    <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Top Referrers</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b dark:border-gray-700">
                        <th class="pb-3 font-medium">Sumber</th>
                        <th class="pb-3 font-medium text-right">Kunjungan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($stats['referrers'] as $referrer => $count)
                    <tr>
                        <td class="py-3 text-gray-600 dark:text-gray-400 truncate max-w-xs">{{ $referrer }}</td>
                        <td class="py-3 text-right font-medium text-gray-900 dark:text-white">{{ number_format($count) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Daily Chart
    const dailyData = @json($dailyStats);
    const dailyLabels = Object.keys(dailyData).map(date => {
        const d = new Date(date);
        return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
    });
    
    new Chart(document.getElementById('dailyChart'), {
        type: 'line',
        data: {
            labels: dailyLabels,
            datasets: [{
                label: 'Pengunjung',
                data: Object.values(dailyData),
                borderColor: '#f59e0b',
                backgroundColor: 'rgba(245, 158, 11, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            }
        }
    });

    // RSVP Chart
    const rsvpData = @json($stats['rsvp']);
    new Chart(document.getElementById('rsvpChart'), {
        type: 'doughnut',
        data: {
            labels: ['Hadir', 'Tidak Hadir', 'Ragu-ragu', 'Pending'],
            datasets: [{
                data: [rsvpData.attending, rsvpData.not_attending, rsvpData.maybe, rsvpData.pending],
                backgroundColor: ['#22c55e', '#ef4444', '#eab308', '#9ca3af'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            cutout: '60%'
        }
    });
});
</script>
@endsection
