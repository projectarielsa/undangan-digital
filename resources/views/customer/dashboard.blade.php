@extends('layouts.dashboard')
@section('page-title', 'Dashboard')
@section('sidebar-nav')
<x-customer-nav />
@endsection

@section('content')
<div class="space-y-8">
    <!-- Welcome Banner -->
    <div class="relative overflow-hidden bg-gradient-to-r from-amber-500 via-amber-600 to-rose-500 rounded-3xl p-8 text-white">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full translate-y-1/2 -translate-x-1/2"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <p class="text-amber-100 text-sm mb-2">Selamat datang kembali,</p>
                <h2 class="text-2xl md:text-3xl font-bold mb-2">{{ auth()->user()->name }}!</h2>
                <p class="text-amber-100 max-w-md">Kelola undangan digital Anda dan pantau statistik pengunjung dengan mudah.</p>
            </div>
            <a href="{{ route('customer.invitations.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-amber-600 font-semibold rounded-xl hover:bg-amber-50 transition-colors shadow-lg shadow-black/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Buat Undangan Baru
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <!-- Total Undangan -->
        <div class="group relative bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:shadow-amber-500/5 hover:border-amber-200 dark:hover:border-amber-800 transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-amber-100 to-amber-200 dark:from-amber-900/50 dark:to-amber-800/50 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="px-2 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 text-xs font-medium rounded-lg">Total</span>
            </div>
            <p class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ $stats['total_invitations'] }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">Undangan</p>
        </div>

        <!-- Published -->
        <div class="group relative bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:shadow-green-500/5 hover:border-green-200 dark:hover:border-green-800 transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-green-100 to-green-200 dark:from-green-900/50 dark:to-green-800/50 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-xs font-medium rounded-lg">Aktif</span>
            </div>
            <p class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ $stats['published'] }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">Dipublikasikan</p>
        </div>


        <!-- Total Views -->
        <div class="group relative bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:shadow-blue-500/5 hover:border-blue-200 dark:hover:border-blue-800 transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/50 dark:to-blue-800/50 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <div class="flex items-center gap-1 text-green-500 text-xs font-medium">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span>12%</span>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ number_format($stats['total_views']) }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Views</p>
        </div>

        <!-- Total Tamu -->
        <div class="group relative bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:shadow-purple-500/5 hover:border-purple-200 dark:hover:border-purple-800 transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-100 to-purple-200 dark:from-purple-900/50 dark:to-purple-800/50 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <span class="px-2 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 text-xs font-medium rounded-lg">RSVP</span>
            </div>
            <p class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ $stats['total_guests'] }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Tamu</p>
        </div>
    </div>


    <!-- Subscription Card -->
    @if($activeSubscription)
    <div class="relative overflow-hidden bg-gradient-to-br from-gray-900 to-gray-800 dark:from-gray-800 dark:to-gray-900 rounded-3xl p-8 text-white">
        <div class="absolute top-0 right-0 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-rose-500/10 rounded-full blur-3xl"></div>
        <div class="relative z-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-amber-400 to-amber-600 rounded-2xl flex items-center justify-center shadow-lg shadow-amber-500/30">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm mb-1">Paket Aktif</p>
                        <h3 class="text-2xl font-bold">{{ $activeSubscription->package->name }}</h3>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <div class="text-left sm:text-right">
                        <p class="text-gray-400 text-sm mb-1">Berlaku hingga</p>
                        <p class="text-lg font-semibold">{{ $activeSubscription->expires_at->format('d M Y') }}</p>
                    </div>
                    <a href="{{ route('customer.packages') }}" class="px-5 py-2.5 bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl text-sm font-medium transition-all backdrop-blur-sm">
                        Upgrade Paket
                    </a>
                </div>
            </div>
            
            <!-- Progress Bar -->
            @php
                $totalDays = $activeSubscription->starts_at->diffInDays($activeSubscription->expires_at);
                $usedDays = $activeSubscription->starts_at->diffInDays(now());
                $percentage = min(100, ($usedDays / $totalDays) * 100);
            @endphp
            <div class="mt-6">
                <div class="flex items-center justify-between text-sm text-gray-400 mb-2">
                    <span>Penggunaan Paket</span>
                    <span>{{ $totalDays - $usedDays }} hari tersisa</span>
                </div>
                <div class="h-2 bg-white/10 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-amber-400 to-rose-500 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="relative overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 rounded-3xl p-8 border-2 border-dashed border-gray-200 dark:border-gray-700">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">Belum Berlangganan</h3>
                    <p class="text-gray-500 dark:text-gray-400">Pilih paket untuk mengaktifkan semua fitur premium</p>
                </div>
            </div>
            <a href="{{ route('customer.packages') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-amber-500 to-rose-500 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-amber-500/25 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Lihat Paket
            </a>
        </div>
    </div>
    @endif


    <!-- Recent Invitations -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="flex items-center justify-between p-6 border-b border-gray-100 dark:border-gray-700">
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Undangan Terbaru</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Kelola dan pantau undangan Anda</p>
            </div>
            <a href="{{ route('customer.invitations.create') }}" class="flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white text-sm font-medium rounded-xl transition-all shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Buat Baru
            </a>
        </div>
        
        @if($invitations->isEmpty())
        <div class="p-12 text-center">
            <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Belum Ada Undangan</h4>
            <p class="text-gray-500 dark:text-gray-400 mb-6 max-w-sm mx-auto">Mulai buat undangan digital pertama Anda dan bagikan momen spesial kepada orang-orang tersayang</p>
            <a href="{{ route('customer.invitations.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-amber-500 to-rose-500 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-amber-500/25 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Buat Undangan Pertama
            </a>
        </div>
        @else
        <div class="divide-y divide-gray-100 dark:divide-gray-700">
            @foreach($invitations as $invitation)
            <div class="group p-5 sm:p-6 flex items-center gap-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <!-- Preview Thumbnail -->
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0 overflow-hidden" style="background: linear-gradient(135deg, {{ $invitation->template->color_primary ?? '#F59E0B' }}30, {{ $invitation->template->color_secondary ?? '#3D3D3D' }}20)">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                
                <!-- Content -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <h4 class="font-semibold text-gray-900 dark:text-white truncate">{{ $invitation->title }}</h4>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $invitation->event_date->format('d M Y') }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ number_format($invitation->views_count ?? 0) }} views
                        </span>
                    </div>
                </div>
                
                <!-- Status Badge -->
                <div class="hidden sm:block">
                    @if($invitation->status === 'published')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-semibold rounded-full">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                        Published
                    </span>
                    @elseif($invitation->status === 'paused')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 text-xs font-semibold rounded-full">
                        <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span>
                        Paused
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-xs font-semibold rounded-full">
                        <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                        Draft
                    </span>
                    @endif
                </div>
                
                <!-- Actions -->
                <div class="flex items-center gap-2">
                    <a href="{{ route('customer.invitations.edit', $invitation) }}" class="p-2.5 text-gray-400 hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/20 rounded-xl transition-colors" title="Edit">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>
                    @if($invitation->status === 'published')
                    <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank" class="p-2.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-xl transition-colors" title="Preview">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- View All Link -->
        @if($invitations->count() >= 5)
        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 text-center">
            <a href="{{ route('customer.invitations.index') }}" class="text-sm font-medium text-amber-600 hover:text-amber-700 dark:text-amber-400 dark:hover:text-amber-300">
                Lihat Semua Undangan &rarr;
            </a>
        </div>
        @endif
        @endif
    </div>
</div>
@endsection
