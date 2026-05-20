@extends('layouts.dashboard')
@section('page-title', 'QR Check-in')
@section('sidebar-nav')<x-customer-nav />@endsection

@section('content')
<div class="max-w-6xl">
    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('customer.invitations.edit', $invitation) }}" class="text-sm text-gray-500 hover:text-amber-600 flex items-center gap-1 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>Kembali
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">QR Check-in</h1>
            <p class="text-gray-500">{{ $invitation->title }}</p>
        </div>
        <div class="flex items-center gap-3">
            <form method="POST" action="{{ route('customer.qr-checkin.generate-all', $invitation) }}">
                @csrf
                <button type="submit" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl hover:bg-gray-200 transition">
                    Generate Semua QR
                </button>
            </form>
            <a href="{{ route('customer.qr-checkin.scanner', $invitation) }}" class="px-4 py-2 bg-gradient-to-r from-amber-600 to-amber-700 text-white text-sm font-semibold rounded-xl shadow-lg hover:shadow-xl transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                Buka Scanner
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl">
        <p class="text-sm text-green-600">{{ session('success') }}</p>
    </div>
    @endif


    <!-- Stats -->
    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6 text-center">
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
            <p class="text-sm text-gray-500">Total Tamu</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6 text-center">
            <p class="text-3xl font-bold text-green-600">{{ $stats['checked_in'] }}</p>
            <p class="text-sm text-gray-500">Sudah Check-in</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6 text-center">
            <p class="text-3xl font-bold text-amber-600">{{ $stats['attending'] }}</p>
            <p class="text-sm text-gray-500">RSVP Hadir</p>
        </div>
    </div>

    <!-- Guest List -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr class="text-left text-gray-500">
                        <th class="px-6 py-4 font-medium">Nama Tamu</th>
                        <th class="px-6 py-4 font-medium">RSVP</th>
                        <th class="px-6 py-4 font-medium">Jumlah</th>
                        <th class="px-6 py-4 font-medium">Status</th>
                        <th class="px-6 py-4 font-medium">Waktu Check-in</th>
                        <th class="px-6 py-4 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($guests as $guest)
                    <tr class="{{ $guest->is_checked_in ? 'bg-green-50 dark:bg-green-900/20' : '' }}">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $guest->name }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                {{ $guest->rsvp_status === 'attending' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $guest->rsvp_status === 'not_attending' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $guest->rsvp_status === 'maybe' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $guest->rsvp_status === 'pending' ? 'bg-gray-100 text-gray-700' : '' }}">
                                {{ ucfirst(str_replace('_', ' ', $guest->rsvp_status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $guest->number_of_guests }} orang</td>
                        <td class="px-6 py-4">
                            @if($guest->is_checked_in)
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Checked In</span>
                            @else
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-700">Belum</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                            {{ $guest->checked_in_at ? $guest->checked_in_at->format('d M H:i') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('customer.qr-checkin.card', [$invitation, $guest]) }}" target="_blank" class="p-2 text-gray-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Lihat QR">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                </a>
                                @if($guest->is_checked_in)
                                <form method="POST" action="{{ route('customer.qr-checkin.undo', [$invitation, $guest]) }}">
                                    @csrf
                                    <button type="submit" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Batalkan Check-in">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </form>
                                @else
                                <form method="POST" action="{{ route('customer.qr-checkin.manual', [$invitation, $guest]) }}">
                                    @csrf
                                    <button type="submit" class="p-2 text-gray-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition" title="Manual Check-in">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            Belum ada tamu. <a href="{{ route('customer.guests.index', $invitation) }}" class="text-amber-600 hover:underline">Tambah tamu</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($guests->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
            {{ $guests->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
