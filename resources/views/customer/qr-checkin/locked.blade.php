@extends('layouts.dashboard')
@section('page-title', 'QR Check-in')
@section('sidebar-nav')<x-customer-nav />@endsection

@section('content')
<div class="max-w-2xl mx-auto text-center py-16">
    <div class="w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-10 h-10 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
        </svg>
    </div>
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Fitur QR Check-in Terkunci</h1>
    <p class="text-gray-600 dark:text-gray-400 mb-8">
        Fitur QR Check-in tersedia hanya untuk paket <strong>Exclusive</strong>.<br>
        Upgrade paket Anda untuk menggunakan fitur check-in tamu dengan QR code.
    </p>
    <div class="bg-white dark:bg-gray-800 rounded-2xl border p-6 text-left mb-8">
        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Dengan fitur QR Check-in, Anda bisa:</h3>
        <ul class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
            <li class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Generate QR code unik untuk setiap tamu
            </li>
            <li class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Scan QR saat tamu datang untuk check-in otomatis
            </li>
            <li class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Lihat statistik kehadiran real-time
            </li>
            <li class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Download kartu undangan dengan QR untuk setiap tamu
            </li>
        </ul>
    </div>
    <a href="{{ route('customer.packages') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-amber-600 to-amber-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
        Upgrade ke Exclusive
    </a>
</div>
@endsection
