@extends('layouts.dashboard')
@section('page-title', 'Priority Support')
@section('sidebar-nav')<x-customer-nav />@endsection

@section('content')
<div class="max-w-4xl">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Tiket Support</h2>
            <p class="text-gray-500 text-sm">Bantuan prioritas untuk pengguna Exclusive</p>
        </div>
        @if($hasPrioritySupport)
        <a href="{{ route('customer.support.create') }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Buat Tiket Baru
        </a>
        @endif
    </div>

    @if(!$hasPrioritySupport)
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-2xl p-6 mb-6">
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h3 class="font-semibold text-blue-800 dark:text-blue-300">Fitur Exclusive</h3>
                <p class="text-blue-700 dark:text-blue-400 text-sm mt-1">Priority Support hanya tersedia untuk paket Exclusive. Upgrade paket Anda untuk mendapatkan dukungan prioritas.</p>
                <a href="{{ route('customer.packages') }}" class="inline-block mt-3 text-sm font-medium text-blue-700 hover:text-blue-800 underline">Lihat Paket →</a>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-2xl border overflow-hidden">
        @forelse($tickets as $ticket)
        <a href="{{ route('customer.support.show', $ticket) }}" class="block p-4 border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
            <div class="flex items-start gap-4">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-xs font-mono text-gray-400">{{ $ticket->ticket_number }}</span>
                        <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-{{ $ticket->status_color }}-100 text-{{ $ticket->status_color }}-700">{{ $ticket->status_label }}</span>
                    </div>
                    <h3 class="font-medium text-gray-900 dark:text-white truncate">{{ $ticket->subject }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $ticket->category_label }} • {{ $ticket->created_at->diffForHumans() }}</p>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </div>
        </a>
        @empty
        <div class="p-8 text-center text-gray-500">
            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
            <p>Belum ada tiket support</p>
            @if($hasPrioritySupport)
            <a href="{{ route('customer.support.create') }}" class="inline-block mt-3 text-blue-600 hover:text-blue-700 font-medium">Buat tiket pertama →</a>
            @endif
        </div>
        @endforelse
    </div>

    @if($tickets->hasPages())
    <div class="mt-6">{{ $tickets->links() }}</div>
    @endif
</div>
@endsection
