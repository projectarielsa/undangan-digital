@extends('layouts.dashboard')
@section('page-title', 'QR Check-in')
@section('sidebar-nav')<x-customer-nav />@endsection

@section('content')
<div class="max-w-6xl">
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('customer.invitations.edit', $invitation) }}" class="text-sm text-gray-500 hover:text-amber-600 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Edit
        </a>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 text-xs font-medium rounded-full bg-indigo-100 text-indigo-700">Exclusive Feature</span>
            <a href="{{ route('customer.invitations.qr-checkin.scanner', $invitation) }}" class="px-4 py-2 bg-amber-600 text-white text-sm font-medium rounded-xl hover:bg-amber-700 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                Buka Scanner
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-5">
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_guests'] }}</p>
            <p class="text-sm text-gray-500">Total Tamu</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-5">
            <p class="text-3xl font-bold text-green-600">{{ $stats['total_attending'] }}</p>
            <p class="text-sm text-gray-500">Konfirmasi Hadir</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-5">
            <p class="text-3xl font-bold text-amber-600">{{ $stats['checked_in'] }}</p>
            <p class="text-sm text-gray-500">Sudah Check-in</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl border p-5">
            <p class="text-3xl font-bold text-blue-600">{{ $stats['expected_count'] }}</p>
            <p class="text-sm text-gray-500">Estimasi Jumlah</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Guest List -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl border">
            <div class="p-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <h3 class="font-semibold text-gray-900 dark:text-white">Daftar Tamu</h3>
                <form method="POST" action="{{ route('customer.invitations.qr-checkin.generate-all', $invitation) }}">
                    @csrf
                    <button type="submit" class="text-sm text-amber-600 hover:text-amber-700 font-medium">Generate Semua QR</button>
                </form>
            </div>
            
            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($guests as $guest)
                <div class="p-4 flex items-center gap-4">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <p class="font-medium text-gray-900 dark:text-white truncate">{{ $guest->name }}</p>
                            @if($guest->is_checked_in)
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-700">Checked In</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-500 mt-1">
                            <span>{{ $guest->number_of_guests }} orang</span>
                            <span>•</span>
                            <span class="{{ $guest->rsvp_status === 'attending' ? 'text-green-600' : ($guest->rsvp_status === 'not_attending' ? 'text-red-600' : 'text-gray-500') }}">
                                {{ ucfirst($guest->rsvp_status) }}
                            </span>
                            @if($guest->checked_in_at)
                            <span>•</span>
                            <span>{{ $guest->checked_in_at->format('H:i') }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        @if($guest->qr_code)
                        <a href="{{ route('customer.invitations.qr-checkin.print', [$invitation, $guest]) }}" target="_blank" class="p-2 text-gray-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Lihat QR Code">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                        </a>
                        @else
                        <form method="POST" action="{{ route('customer.invitations.qr-checkin.generate', [$invitation, $guest]) }}">
                            @csrf
                            <button type="submit" class="p-2 text-gray-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition" title="Generate QR">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            </button>
                        </form>
                        @endif

                        @if(!$guest->is_checked_in)
                        <form method="POST" action="{{ route('customer.invitations.qr-checkin.manual', [$invitation, $guest]) }}">
                            @csrf
                            <button type="submit" class="p-2 text-gray-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition" title="Manual Check-in">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </button>
                        </form>
                        @else
                        <form method="POST" action="{{ route('customer.invitations.qr-checkin.undo', [$invitation, $guest]) }}">
                            @csrf
                            <button type="submit" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Batalkan Check-in">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-gray-500">
                    <p>Belum ada tamu. <a href="{{ route('customer.guests.index', $invitation) }}" class="text-amber-600 hover:underline">Tambah tamu</a></p>
                </div>
                @endforelse
            </div>

            @if($guests->hasPages())
            <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                {{ $guests->links() }}
            </div>
            @endif
        </div>

        <!-- Recent Check-ins -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border">
            <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                <h3 class="font-semibold text-gray-900 dark:text-white">Check-in Terbaru</h3>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-gray-700 max-h-96 overflow-y-auto">
                @forelse($recentCheckins as $checkin)
                <div class="p-4">
                    <p class="font-medium text-gray-900 dark:text-white">{{ $checkin->name }}</p>
                    <div class="flex items-center gap-2 text-sm text-gray-500 mt-1">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/></svg>
                        <span>{{ $checkin->checked_in_at->format('H:i') }}</span>
                        <span>•</span>
                        <span>{{ $checkin->number_of_guests }} orang</span>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-gray-500">
                    <p>Belum ada check-in</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
