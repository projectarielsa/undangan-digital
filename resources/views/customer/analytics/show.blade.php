@extends('layouts.dashboard')
@section('page-title', 'Analytics - ' . $invitation->title)
@section('sidebar-nav')<x-customer-nav />@endsection

@section('content')
<div class="max-w-6xl">
    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('customer.invitations.edit', $invitation) }}" class="text-sm text-gray-500 hover:text-amber-600 flex items-center gap-1 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>Kembali ke Undangan
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Analytics Dashboard</h1>
            <p class="text-gray-500">{{ $invitation->title }}</p>
        </div>
        <div>
            <form method="GET" class="flex items-center gap-2">
                <select name="period" onchange="this.form.submit()" class="px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm">
                    <option value="7" {{ $period == '7' ? 'selected' : '' }}>7 Hari Terakhir</option>
                    <option value="14" {{ $period == '14' ? 'selected' : '' }}>14 Hari Terakhir</option>
                    <option value="30" {{ $period == '30' ? 'selected' : '' }}>30 Hari Terakhir</option>
                    <option value="90" {{ $period == '90' ? 'selected' : '' }}>90 Hari Terakhir</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
            <p class="text-sm text-gray-500 mb-1">Total Views</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($totalViews) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
            <p class="text-sm text-gray-500 mb-1">Views ({{ $period }} Hari)</p>
            <p class="text-3xl font-bold text-amber-600">{{ number_format($periodViews) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
            <p class="text-sm text-gray-500 mb-1">Unique Visitors</p>
            <p class="text-3xl font-bold text-blue-600">{{ number_format($uniqueVisitors) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
            <p class="text-sm text-gray-500 mb-1">Open Rate</p>
            <p class="text-3xl font-bold text-green-600">{{ $openRate }}%</p>
            <p class="text-xs text-gray-400">{{ $openedGuests }}/{{ $totalGuests }} tamu</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6 mb-8">
        <!-- Views Chart -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl border p-6">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Views Per Hari</h3>
            <div class="h-64">
                <canvas id="viewsChart"></canvas>
            </div>
        </div>

        <!-- Device Breakdown -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Device</h3>
            <div class="h-48 flex items-center justify-center">
                <canvas id="deviceChart"></canvas>
            </div>
            <div class="mt-4 space-y-2">
                @foreach($deviceStats as $device => $count)
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-400 capitalize">{{ $device }}</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $count }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6 mb-8">
        <!-- RSVP Stats -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">RSVP Status</h3>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-green-600">Hadir</span>
                        <span class="font-medium">{{ $rsvpStats['attending'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $rsvpStats['total'] > 0 ? ($rsvpStats['attending'] / $rsvpStats['total']) * 100 : 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-red-600">Tidak Hadir</span>
                        <span class="font-medium">{{ $rsvpStats['not_attending'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-red-500 h-2 rounded-full" style="width: {{ $rsvpStats['total'] > 0 ? ($rsvpStats['not_attending'] / $rsvpStats['total']) * 100 : 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-yellow-600">Mungkin</span>
                        <span class="font-medium">{{ $rsvpStats['maybe'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $rsvpStats['total'] > 0 ? ($rsvpStats['maybe'] / $rsvpStats['total']) * 100 : 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-500">Pending</span>
                        <span class="font-medium">{{ $rsvpStats['pending'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-gray-400 h-2 rounded-full" style="width: {{ $rsvpStats['total'] > 0 ? ($rsvpStats['pending'] / $rsvpStats['total']) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Total Tamu</span>
                    <span class="font-bold text-gray-900 dark:text-white">{{ $rsvpStats['total'] }}</span>
                </div>
            </div>
        </div>

        <!-- Browser & Peak Hours -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Browser</h3>
                <div class="space-y-2">
                    @forelse($browserStats as $browser => $count)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">{{ $browser }}</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $count }}</span>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500">Belum ada data</p>
                    @endforelse
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Jam Ramai</h3>
                <div class="space-y-2">
                    @forelse($peakHours as $hour)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">{{ str_pad($hour->hour, 2, '0', STR_PAD_LEFT) }}:00</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $hour->count }} views</span>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500">Belum ada data</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Visitors -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Pengunjung Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b border-gray-200 dark:border-gray-700">
                        <th class="pb-3 font-medium">Waktu</th>
                        <th class="pb-3 font-medium">Tamu</th>
                        <th class="pb-3 font-medium">Device</th>
                        <th class="pb-3 font-medium">Browser</th>
                        <th class="pb-3 font-medium">Sumber</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($recentViews as $view)
                    <tr>
                        <td class="py-3 text-gray-600 dark:text-gray-400">{{ $view->viewed_at->diffForHumans() }}</td>
                        <td class="py-3">
                            @if($view->guest)
                            <span class="text-amber-600 font-medium">{{ $view->guest->name }}</span>
                            @else
                            <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="py-3 capitalize text-gray-600 dark:text-gray-400">{{ $view->device_type }}</td>
                        <td class="py-3 text-gray-600 dark:text-gray-400">{{ $view->browser }}</td>
                        <td class="py-3 text-gray-600 dark:text-gray-400 truncate max-w-[150px]">{{ $view->referrer ?? 'Direct' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500">Belum ada data pengunjung</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Views Chart
    const viewsCtx = document.getElementById('viewsChart').getContext('2d');
    new Chart(viewsCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_keys($chartData)) !!}.map(d => new Date(d).toLocaleDateString('id-ID', {day: 'numeric', month: 'short'})),
            datasets: [{
                label: 'Views',
                data: {!! json_encode(array_values($chartData)) !!},
                borderColor: '#f59e0b',
                backgroundColor: 'rgba(245, 158, 11, 0.1)',
                fill: true,
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    // Device Chart
    const deviceCtx = document.getElementById('deviceChart').getContext('2d');
    new Chart(deviceCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($deviceStats)) !!},
            datasets: [{
                data: {!! json_encode(array_values($deviceStats)) !!},
                backgroundColor: ['#f59e0b', '#3b82f6', '#10b981'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
});
</script>
@endsection
