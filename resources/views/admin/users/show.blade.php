@extends('layouts.dashboard')
@section('page-title', 'Detail User')
@section('sidebar-nav')<x-admin-nav />@endsection

@section('content')
<div class="max-w-4xl space-y-6">
    <!-- Back Button -->
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke Daftar User
    </a>

    @if(session('success'))
    <div class="p-4 bg-green-50 border border-green-200 rounded-xl">
        <p class="text-sm text-green-700">{{ session('success') }}</p>
    </div>
    @endif

    <!-- User Info Card -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi User</h3>
            <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                @csrf
                <button class="px-3 py-1.5 text-sm font-medium rounded-lg {{ $user->is_active ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }} transition">
                    {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                </button>
            </form>
        </div>
        <dl class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
            <div><dt class="text-gray-500">Nama</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</dd></div>
            <div><dt class="text-gray-500">Email</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $user->email }}</dd></div>
            <div><dt class="text-gray-500">Bergabung</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $user->created_at->format('d M Y') }}</dd></div>
            <div><dt class="text-gray-500">Status</dt><dd><span class="px-2 py-0.5 text-xs rounded-full {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</span></dd></div>
            <div><dt class="text-gray-500">Jumlah Undangan</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $user->invitations->count() }}</dd></div>
            <div><dt class="text-gray-500">Total Pembayaran</dt><dd class="font-medium text-gray-900 dark:text-white">{{ $user->payments->count() }}</dd></div>
        </dl>
    </div>


    <!-- Subscription Management Card -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Kelola Langganan</h3>
        
        <!-- Add Subscription Form -->
        <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 mb-6">
            <h4 class="font-medium text-gray-900 dark:text-white mb-3">Tambah Langganan Baru</h4>
            <form method="POST" action="{{ route('admin.users.subscription.add', $user) }}" class="flex flex-wrap items-end gap-4">
                @csrf
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm text-gray-600 dark:text-gray-400 mb-1">Paket</label>
                    <select name="package_id" required class="w-full px-3 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="">Pilih Paket</option>
                        @foreach($packages as $package)
                        <option value="{{ $package->id }}">{{ $package->name }} - Rp {{ number_format($package->getEffectivePrice(), 0, ',', '.') }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-32">
                    <label class="block text-sm text-gray-600 dark:text-gray-400 mb-1">Durasi (hari)</label>
                    <input type="number" name="duration_days" value="30" min="1" max="365" required class="w-full px-3 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                    Tambah Langganan
                </button>
            </form>
            @if($errors->any())
            <div class="mt-2">
                @foreach($errors->all() as $error)
                <p class="text-sm text-red-600">{{ $error }}</p>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Subscription List -->
        <h4 class="font-medium text-gray-900 dark:text-white mb-3">Riwayat Langganan</h4>
        @if($user->subscriptions->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Paket</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Mulai</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Berakhir</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($user->subscriptions->sortByDesc('created_at') as $subscription)
                    <tr>
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $subscription->package?->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $subscription->starts_at->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $subscription->expires_at->format('d M Y H:i') }}</td>
                        <td class="px-4 py-3">
                            @if($subscription->status === 'active' && $subscription->expires_at->isFuture())
                            <span class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-700">Aktif</span>
                            @elseif($subscription->status === 'cancelled')
                            <span class="px-2 py-0.5 text-xs rounded-full bg-red-100 text-red-700">Dibatalkan</span>
                            @else
                            <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-700">Kadaluarsa</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                @if($subscription->status === 'active' && $subscription->expires_at->isFuture())
                                <!-- Extend Form -->
                                <form method="POST" action="{{ route('admin.subscriptions.extend', $subscription) }}" class="flex items-center gap-1">
                                    @csrf
                                    <input type="number" name="days" value="30" min="1" max="365" class="w-16 px-2 py-1 text-xs border rounded">
                                    <button type="submit" class="text-xs text-blue-600 hover:underline">+Hari</button>
                                </form>
                                <!-- Cancel -->
                                <form method="POST" action="{{ route('admin.subscriptions.cancel', $subscription) }}" onsubmit="return confirm('Batalkan langganan ini?')">
                                    @csrf
                                    <button type="submit" class="text-xs text-red-600 hover:underline">Batalkan</button>
                                </form>
                                @else
                                <span class="text-xs text-gray-400">-</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-8 text-gray-500">
            <svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p>Belum ada langganan</p>
        </div>
        @endif
    </div>


    <!-- User Invitations -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Undangan ({{ $user->invitations->count() }})</h3>
        @if($user->invitations->count() > 0)
        <div class="space-y-3">
            @foreach($user->invitations->take(5) as $inv)
            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $inv->title }}</p>
                    <p class="text-xs text-gray-500">{{ $inv->event_date->format('d M Y') }} - {{ $inv->event_venue }}</p>
                </div>
                <span class="px-2 py-0.5 text-xs rounded-full {{ $inv->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">{{ ucfirst($inv->status) }}</span>
            </div>
            @endforeach
        </div>
        @if($user->invitations->count() > 5)
        <p class="text-sm text-gray-500 mt-3">dan {{ $user->invitations->count() - 5 }} undangan lainnya...</p>
        @endif
        @else
        <p class="text-gray-500 text-sm">Belum ada undangan</p>
        @endif
    </div>
</div>
@endsection
