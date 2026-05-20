@extends('layouts.dashboard')
@section('page-title', 'Kelola Paket & Harga')
@section('sidebar-nav')<x-admin-nav />@endsection

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Paket & Harga</h2>
    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola harga dan fitur paket layanan</p>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($packages as $package)
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden {{ $package->is_featured ? 'ring-2 ring-blue-500' : '' }}">
        <!-- Header -->
        <div class="p-6 border-b border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $package->name }}</h3>
                <div class="flex items-center gap-2">
                    @if($package->is_featured)
                    <span class="text-xs bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 px-2 py-0.5 rounded-full">Populer</span>
                    @endif
                    @if($package->is_active)
                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                    @else
                    <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                    @endif
                </div>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $package->description }}</p>
        </div>

        <!-- Pricing -->
        <div class="p-6 border-b border-gray-100 dark:border-gray-700">
            @if($package->discount_price)
            <p class="text-sm text-gray-400 line-through">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($package->discount_price, 0, ',', '.') }}</p>
            <p class="text-xs text-green-600 dark:text-green-400 mt-1">Hemat {{ round((($package->price - $package->discount_price) / $package->price) * 100) }}%</p>
            @else
            <p class="text-3xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
            @endif
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">/ {{ $package->duration_days }} hari</p>
        </div>

        <!-- Quick Info -->
        <div class="p-6 border-b border-gray-100 dark:border-gray-700">
            <div class="grid grid-cols-3 gap-3 text-center text-xs">
                <div>
                    <p class="font-bold text-gray-900 dark:text-white">{{ $package->max_photos == 999 ? '∞' : $package->max_photos }}</p>
                    <p class="text-gray-500">Foto</p>
                </div>
                <div>
                    <p class="font-bold text-gray-900 dark:text-white">{{ $package->max_guests == 9999 ? '∞' : $package->max_guests }}</p>
                    <p class="text-gray-500">Tamu</p>
                </div>
                <div>
                    <p class="font-bold text-gray-900 dark:text-white">{{ $package->max_templates == 999 ? '∞' : $package->max_templates }}</p>
                    <p class="text-gray-500">Template</p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="p-4">
            <a href="{{ route('admin.packages.edit', $package) }}" class="block w-full text-center px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition">
                Edit Paket
            </a>
        </div>
    </div>
    @endforeach
</div>
@endsection
