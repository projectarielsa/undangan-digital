@extends('layouts.dashboard')
@section('page-title', 'Detail User')
@section('sidebar-nav')<x-admin-nav />@endsection

@section('content')
<div class="max-w-4xl space-y-6">

    {{-- User Info Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $user->name }}</h3>
            <span class="px-3 py-1 text-xs rounded-full {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</span>
        </div>
        <dl class="grid grid-cols-2 gap-4 text-sm">
            <div><dt class="text-gray-500">Email</dt><dd class="font-medium">{{ $user->email }}</dd></div>
            <div><dt class="text-gray-500">Bergabung</dt><dd class="font-medium">{{ $user->created_at->format('d M Y') }}</dd></div>
            <div><dt class="text-gray-500">Undangan</dt><dd class="font-medium">{{ $user->invitations->count() }}</dd></div>
            <div><dt class="text-gray-500">Pembayaran</dt><dd class="font-medium">{{ $user->payments->count() }}</dd></div>
        </dl>
    </div>

    {{-- Active Subscription Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Langganan Aktif</h3>

        @if($activeSubscription)
        <div class="flex items-center justify-between p-4 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-200 dark:border-amber-800">
            <div>
                <p class="font-semibold text-amber-800 dark:text-amber-200">{{ $activeSubscription->package->name }}</p>
                <p class="text-sm text-amber-600 dark:text-amber-400 mt-1">
                    Berlaku sampai: <strong>{{ $activeSubscription->expires_at->format('d M Y') }}</strong>
                    ({{ $activeSubscription->expires_at->diffForHumans() }})
                </p>
                <p class="text-xs text-amber-500 mt-1">Mulai: {{ $activeSubscription->starts_at->format('d M Y') }}</p>
            </div>
            <form method="POST" action="{{ route('admin.users.revoke-subscription', $user) }}" onsubmit="return confirm('Yakin ingin mencabut langganan user ini?')">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-100 text-red-700 text-xs font-semibold rounded-lg hover:bg-red-200 transition">
                    Cabut Langganan
                </button>
            </form>
        </div>
        @else
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">User ini belum memiliki langganan aktif.</p>
        @endif
    </div>

    {{-- Grant Subscription Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Berikan Langganan</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Berikan paket langganan kepada user ini secara manual (tanpa pembayaran).</p>

        @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl">
            <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.users.grant-subscription', $user) }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pilih Paket</label>
                <select name="package_id" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500">
                    @foreach($packages as $package)
                    <option value="{{ $package->id }}">{{ $package->name }} — Rp {{ number_format($package->getEffectivePrice(), 0, ',', '.') }} ({{ $package->max_guests }} tamu, {{ $package->max_photos }} foto)</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Durasi (hari)</label>
                <select name="duration_days" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500">
                    <option value="30">30 hari (1 bulan)</option>
                    <option value="90">90 hari (3 bulan)</option>
                    <option value="180">180 hari (6 bulan)</option>
                    <option value="365" selected>365 hari (1 tahun)</option>
                    <option value="730">730 hari (2 tahun)</option>
                    <option value="3650">3650 hari (10 tahun / selamanya)</option>
                </select>
            </div>
            <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-amber-600 to-amber-700 text-white font-semibold rounded-xl hover:from-amber-700 hover:to-amber-800 transition shadow-lg shadow-amber-500/25">
                Berikan Langganan
            </button>
        </form>
    </div>

    {{-- Subscription History --}}
    @if($user->subscriptions->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Riwayat Langganan</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paket</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mulai</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Berakhir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($user->subscriptions->sortByDesc('created_at') as $sub)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $sub->package->name ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 text-xs rounded-full {{ $sub->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ ucfirst($sub->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $sub->starts_at?->format('d M Y') ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $sub->expires_at?->format('d M Y') ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>
@endsection
