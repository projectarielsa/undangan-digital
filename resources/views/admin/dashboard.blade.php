@extends('layouts.dashboard')
@section('page-title', 'Admin Dashboard')
@section('sidebar-nav')<x-admin-nav />@endsection

@section('content')
<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border"><p class="text-sm text-gray-500 mb-1">Total Users</p><p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_users']) }}</p></div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border"><p class="text-sm text-gray-500 mb-1">Total Undangan</p><p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_invitations']) }}</p></div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border"><p class="text-sm text-gray-500 mb-1">Published</p><p class="text-2xl font-bold text-green-600">{{ number_format($stats['published_invitations']) }}</p></div>
    <div class="bg-gradient-to-br from-amber-500 to-amber-700 rounded-2xl p-5 text-white"><p class="text-sm text-amber-100 mb-1">Total Revenue</p><p class="text-2xl font-bold">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p></div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border"><p class="text-sm text-gray-500 mb-1">Revenue Bulan Ini</p><p class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($stats['monthly_revenue'], 0, ',', '.') }}</p></div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border"><p class="text-sm text-gray-500 mb-1">Pending Payments</p><p class="text-2xl font-bold text-yellow-600">{{ $stats['pending_payments'] }}</p></div>
</div>

<div class="grid lg:grid-cols-2 gap-8">
    <!-- Recent Payments -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border">
        <div class="p-6 border-b"><h3 class="font-semibold text-gray-900 dark:text-white">Pembayaran Terbaru</h3></div>
        <div class="divide-y divide-gray-100 dark:divide-gray-700">
            @foreach($recentPayments as $payment)
            <div class="px-6 py-4 flex items-center justify-between">
                <div><p class="font-medium text-gray-900 dark:text-white text-sm">{{ $payment->user->name }}</p><p class="text-xs text-gray-500">{{ $payment->package->name }}</p></div>
                <div class="text-right"><p class="font-medium text-sm text-gray-900 dark:text-white">Rp {{ number_format($payment->total_amount, 0, ',', '.') }}</p><p class="text-xs text-gray-400">{{ $payment->paid_at?->format('d M') }}</p></div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Users -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border">
        <div class="p-6 border-b"><h3 class="font-semibold text-gray-900 dark:text-white">User Terbaru</h3></div>
        <div class="divide-y divide-gray-100 dark:divide-gray-700">
            @foreach($recentUsers as $user)
            <div class="px-6 py-4 flex items-center justify-between">
                <div><p class="font-medium text-gray-900 dark:text-white text-sm">{{ $user->name }}</p><p class="text-xs text-gray-500">{{ $user->email }}</p></div>
                <span class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
