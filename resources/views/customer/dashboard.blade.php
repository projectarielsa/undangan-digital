@extends('layouts.dashboard')
@section('page-title', 'Dashboard')
@section('sidebar-nav')
<x-customer-nav />
@endsection

@section('content')
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700">
        <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center mb-3">
            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_invitations'] }}</p>
        <p class="text-sm text-gray-500">Total Undangan</p>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700">
        <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center mb-3">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['published'] }}</p>
        <p class="text-sm text-gray-500">Dipublikasikan</p>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700">
        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center mb-3">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
        </div>
        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_views']) }}</p>
        <p class="text-sm text-gray-500">Total Views</p>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700">
        <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center mb-3">
            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </div>
        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_guests'] }}</p>
        <p class="text-sm text-gray-500">Total Tamu</p>
    </div>
</div>

@if($activeSubscription)
<div class="bg-gradient-to-r from-amber-500 to-amber-700 rounded-2xl p-6 mb-8 text-white">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <p class="text-amber-100 text-sm">Paket Aktif</p>
            <h3 class="text-xl font-bold">{{ $activeSubscription->package->name }}</h3>
            <p class="text-amber-100 text-sm mt-1">Berlaku hingga {{ $activeSubscription->expires_at->format('d M Y') }}</p>
        </div>
        <a href="{{ route('customer.packages') }}" class="px-4 py-2 bg-white/20 hover:bg-white/30 rounded-xl text-sm font-medium transition">Upgrade Paket</a>
    </div>
</div>
@else
<div class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-6 mb-8 border border-gray-200 dark:border-gray-700">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h3 class="font-semibold text-gray-900 dark:text-white">Belum Berlangganan</h3>
            <p class="text-sm text-gray-500">Pilih paket untuk mengaktifkan semua fitur premium</p>
        </div>
        <a href="{{ route('customer.packages') }}" class="px-5 py-2.5 bg-gradient-to-r from-amber-600 to-amber-700 text-white rounded-xl text-sm font-semibold shadow-lg shadow-amber-500/25 transition">Lihat Paket</a>
    </div>
</div>
@endif

<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
    <div class="flex items-center justify-between p-6 border-b border-gray-100 dark:border-gray-700">
        <h3 class="font-semibold text-gray-900 dark:text-white">Undangan Terbaru</h3>
        <a href="{{ route('customer.invitations.create') }}" class="flex items-center gap-2 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-sm font-medium rounded-xl transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>Buat Baru
        </a>
    </div>
    @if($invitations->isEmpty())
    <div class="p-12 text-center">
        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <h4 class="font-medium text-gray-900 dark:text-white mb-1">Belum Ada Undangan</h4>
        <p class="text-sm text-gray-500">Mulai buat undangan digital pertama Anda</p>
    </div>
    @else
    <div class="divide-y divide-gray-100 dark:divide-gray-700">
        @foreach($invitations as $invitation)
        <div class="p-4 sm:p-6 flex items-center justify-between gap-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
            <div class="flex-1 min-w-0">
                <h4 class="font-medium text-gray-900 dark:text-white truncate">{{ $invitation->title }}</h4>
                <p class="text-sm text-gray-500">{{ $invitation->event_date->format('d M Y') }}</p>
            </div>
            <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $invitation->status === 'published' ? 'bg-green-100 text-green-700' : ($invitation->status === 'paused' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700') }}">{{ ucfirst($invitation->status) }}</span>
            <a href="{{ route('customer.invitations.edit', $invitation) }}" class="p-2 text-gray-400 hover:text-amber-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </a>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
