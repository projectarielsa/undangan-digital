@extends('layouts.dashboard')
@section('page-title', 'Kelola Tamu')
@section('sidebar-nav')<x-customer-nav />@endsection

@section('content')
<div class="max-w-4xl">
    <div class="mb-6"><a href="{{ route('customer.invitations.edit', $invitation) }}" class="text-sm text-gray-500 hover:text-amber-600 flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>Kembali ke Undangan</a></div>

    <!-- RSVP Stats -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border text-center"><p class="text-2xl font-bold">{{ $rsvpStats['total'] }}</p><p class="text-xs text-gray-500">Total</p></div>
        <div class="bg-green-50 rounded-xl p-4 border border-green-200 text-center"><p class="text-2xl font-bold text-green-600">{{ $rsvpStats['attending'] }}</p><p class="text-xs text-green-600">Hadir</p></div>
        <div class="bg-red-50 rounded-xl p-4 border border-red-200 text-center"><p class="text-2xl font-bold text-red-600">{{ $rsvpStats['not_attending'] }}</p><p class="text-xs text-red-600">Tidak</p></div>
        <div class="bg-yellow-50 rounded-xl p-4 border border-yellow-200 text-center"><p class="text-2xl font-bold text-yellow-600">{{ $rsvpStats['maybe'] }}</p><p class="text-xs text-yellow-600">Mungkin</p></div>
        <div class="bg-gray-50 rounded-xl p-4 border text-center"><p class="text-2xl font-bold text-gray-500">{{ $rsvpStats['pending'] }}</p><p class="text-xs text-gray-500">Pending</p></div>
    </div>

    <!-- Add Guest -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6 mb-6">
        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Tambah Tamu</h3>
        <form method="POST" action="{{ route('customer.guests.store', $invitation) }}" class="flex flex-wrap gap-3">
            @csrf
            <input type="text" name="name" required placeholder="Nama tamu" class="flex-1 min-w-[200px] px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500">
            <input type="text" name="phone" placeholder="No. HP" class="w-40 px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500">
            <input type="email" name="email" placeholder="Email" class="w-48 px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-amber-500">
            <button type="submit" class="px-5 py-2.5 bg-amber-600 text-white text-sm font-medium rounded-xl hover:bg-amber-700 transition">Tambah</button>
        </form>
    </div>

    <!-- Import -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6 mb-6">
        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Import dari CSV/Excel</h3>
        <form method="POST" action="{{ route('customer.guests.import', $invitation) }}" enctype="multipart/form-data" class="flex items-center gap-3">
            @csrf
            <input type="file" name="file" accept=".csv,.xlsx,.xls" required class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700">
            <button type="submit" class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl hover:bg-gray-200 transition">Import</button>
        </form>
        <p class="text-xs text-gray-400 mt-2">Format: Nama, No HP, Email (satu baris per tamu)</p>
    </div>

    <!-- Guest List -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border">
        <div class="p-6 border-b"><h3 class="font-semibold text-gray-900 dark:text-white">Daftar Tamu ({{ $guests->total() }})</h3></div>
        @if($guests->isEmpty())
        <div class="p-8 text-center text-gray-500">Belum ada tamu yang ditambahkan.</div>
        @else
        <div class="divide-y divide-gray-100 dark:divide-gray-700">
            @foreach($guests as $guest)
            <div class="p-4 flex items-center justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-gray-900 dark:text-white">{{ $guest->name }}</p>
                    <p class="text-xs text-gray-500">{{ $guest->phone }} {{ $guest->email }}</p>
                </div>
                <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $guest->rsvp_status === 'attending' ? 'bg-green-100 text-green-700' : ($guest->rsvp_status === 'not_attending' ? 'bg-red-100 text-red-700' : ($guest->rsvp_status === 'maybe' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-600')) }}">{{ ucfirst(str_replace('_', ' ', $guest->rsvp_status)) }}</span>
                <form method="POST" action="{{ route('customer.guests.destroy', [$invitation, $guest]) }}" onsubmit="return confirm('Hapus tamu ini?')">@csrf @method('DELETE')<button class="p-1 text-gray-400 hover:text-red-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></form>
            </div>
            @endforeach
        </div>
        <div class="p-4">{{ $guests->links() }}</div>
        @endif
    </div>
</div>
@endsection
