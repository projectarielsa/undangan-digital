@extends('layouts.dashboard')
@section('page-title', 'Admin Dashboard')
@section('sidebar-nav')<x-admin-nav />@endsection

@section('content')
<div class="space-y-8">
    <!-- Welcome Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Dashboard Overview</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Pantau performa dan aktivitas platform</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-sm text-gray-500 dark:text-gray-400">{{ now()->format('d M Y') }}</span>
            <div class="h-6 w-px bg-gray-200 dark:bg-gray-700"></div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-semibold rounded-full">
                <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                System Online
            </span>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
        <!-- Total Users -->
        <div class="group relative bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:shadow-blue-500/5 transition-all duration-300 hover:-translate-y-1 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/50 dark:to-blue-800/50 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div class="flex items-center gap-1 text-green-500 text-xs font-medium">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span>8%</span>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ number_format($stats['total_users']) }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Users</p>
            </div>
        </div>

        <!-- Total Invitations -->
        <div class="group relative bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:shadow-amber-500/5 transition-all duration-300 hover:-translate-y-1 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/5 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-amber-100 to-amber-200 dark:from-amber-900/50 dark:to-amber-800/50 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="px-2 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 text-xs font-medium rounded-lg">Total</span>
                </div>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ number_format($stats['total_invitations']) }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Undangan</p>
            </div>
        </div>

        <!-- Published -->
        <div class="group relative bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:shadow-green-500/5 transition-all duration-300 hover:-translate-y-1 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-green-500/5 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-100 to-green-200 dark:from-green-900/50 dark:to-green-800/50 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-xs font-medium rounded-lg">Active</span>
                </div>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400 mb-1">{{ number_format($stats['published_invitations']) }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Published</p>
            </div>
        </div>


        <!-- Total Revenue -->
        <div class="group relative bg-gradient-to-br from-amber-500 via-amber-600 to-rose-500 rounded-2xl p-6 text-white overflow-hidden hover:shadow-xl hover:shadow-amber-500/20 transition-all duration-300 hover:-translate-y-1">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/10 rounded-full translate-y-1/2 -translate-x-1/2"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="px-2 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-medium rounded-lg">Revenue</span>
                </div>
                <p class="text-3xl font-bold mb-1">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                <p class="text-sm text-white/80">Total Revenue</p>
            </div>
        </div>

        <!-- Monthly Revenue -->
        <div class="group relative bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:shadow-emerald-500/5 transition-all duration-300 hover:-translate-y-1 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-100 to-emerald-200 dark:from-emerald-900/50 dark:to-emerald-800/50 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                    <div class="flex items-center gap-1 text-green-500 text-xs font-medium">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span>15%</span>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mb-1">Rp {{ number_format($stats['monthly_revenue'], 0, ',', '.') }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Revenue Bulan Ini</p>
            </div>
        </div>

        <!-- Pending Payments -->
        <div class="group relative bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:shadow-yellow-500/5 transition-all duration-300 hover:-translate-y-1 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-500/5 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-100 to-yellow-200 dark:from-yellow-900/50 dark:to-yellow-800/50 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    @if($stats['pending_payments'] > 0)
                    <span class="px-2 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400 text-xs font-medium rounded-lg animate-pulse">Perlu Ditinjau</span>
                    @endif
                </div>
                <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400 mb-1">{{ $stats['pending_payments'] }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Pending Payments</p>
            </div>
        </div>
    </div>


    <!-- Content Grid -->
    <div class="grid lg:grid-cols-2 gap-6">
        <!-- Recent Payments -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="flex items-center justify-between p-6 border-b border-gray-100 dark:border-gray-700">
                <div>
                    <h3 class="font-bold text-gray-900 dark:text-white">Pembayaran Terbaru</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Transaksi yang berhasil</p>
                </div>
                <a href="{{ route('admin.payments.index') }}" class="text-sm text-amber-600 dark:text-amber-400 hover:text-amber-700 font-medium">Lihat Semua</a>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($recentPayments as $payment)
                <div class="p-4 flex items-center gap-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-100 to-amber-200 dark:from-amber-900/50 dark:to-amber-800/50 flex items-center justify-center flex-shrink-0">
                        <span class="text-amber-700 dark:text-amber-300 font-semibold text-sm">{{ strtoupper(substr($payment->user->name, 0, 1)) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-900 dark:text-white text-sm truncate">{{ $payment->user->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $payment->package->name }}</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="font-semibold text-sm text-gray-900 dark:text-white">Rp {{ number_format($payment->total_amount, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-400">{{ $payment->paid_at?->format('d M') }}</p>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    <p class="text-sm">Belum ada pembayaran</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Users -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="flex items-center justify-between p-6 border-b border-gray-100 dark:border-gray-700">
                <div>
                    <h3 class="font-bold text-gray-900 dark:text-white">User Terbaru</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Pendaftar baru di platform</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="text-sm text-amber-600 dark:text-amber-400 hover:text-amber-700 font-medium">Lihat Semua</a>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($recentUsers as $user)
                <div class="p-4 flex items-center gap-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/50 dark:to-blue-800/50 flex items-center justify-center flex-shrink-0">
                        <span class="text-blue-700 dark:text-blue-300 font-semibold text-sm">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-900 dark:text-white text-sm truncate">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $user->email }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        @if($user->email_verified_at)
                        <span class="w-2 h-2 bg-green-500 rounded-full" title="Verified"></span>
                        @else
                        <span class="w-2 h-2 bg-gray-300 rounded-full" title="Unverified"></span>
                        @endif
                        <span class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <p class="text-sm">Belum ada user terdaftar</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 rounded-3xl p-6 border border-gray-200 dark:border-gray-700">
        <h3 class="font-bold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.templates.create') }}" class="flex items-center gap-3 p-4 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 hover:border-amber-300 dark:hover:border-amber-700 hover:shadow-lg transition-all group">
                <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Tambah Template</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 p-4 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-700 hover:shadow-lg transition-all group">
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Kelola Users</span>
            </a>
            <a href="{{ route('admin.payments.index') }}" class="flex items-center gap-3 p-4 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 hover:border-green-300 dark:hover:border-green-700 hover:shadow-lg transition-all group">
                <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Lihat Transaksi</span>
            </a>
            <a href="{{ route('admin.invitations.index') }}" class="flex items-center gap-3 p-4 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 hover:border-purple-300 dark:hover:border-purple-700 hover:shadow-lg transition-all group">
                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Semua Undangan</span>
            </a>
        </div>
    </div>
</div>
@endsection
