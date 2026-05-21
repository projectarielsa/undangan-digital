@extends('layouts.dashboard')
@section('page-title', 'Pilih Paket')
@section('sidebar-nav')<x-customer-nav />@endsection

@section('content')
<div class="text-center mb-8">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Pilih Paket Terbaik</h2>
    <p class="text-gray-500">Unlock semua fitur premium untuk undangan Anda</p>
</div>
<div class="grid md:grid-cols-3 gap-6 max-w-5xl mx-auto">
    @foreach($packages as $package)
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border-2 {{ $package->is_featured ? 'border-blue-500 shadow-xl' : 'border-gray-100 dark:border-gray-700' }} relative">
        @if($package->is_featured)<div class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-1 bg-blue-500 text-white text-xs font-bold rounded-full">POPULER</div>@endif
        <div class="text-center mb-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $package->name }}</h3>
            <p class="text-sm text-gray-500 mt-1">{{ $package->description }}</p>
            @if($package->discount_price)<p class="text-sm text-gray-400 line-through mt-4">Rp {{ number_format($package->price, 0, ',', '.') }}</p>@endif
            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">Rp {{ number_format($package->getEffectivePrice(), 0, ',', '.') }}</p>
        </div>
        <ul class="space-y-2 mb-6">
            @if($package->features)@foreach($package->features as $feature)
            <li class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>{{ $feature }}
            </li>
            @endforeach @endif
        </ul>
        <form method="POST" action="{{ route('customer.checkout', $package) }}">
            @csrf
            <button type="submit" class="w-full py-3 text-center font-semibold rounded-xl transition {{ $package->is_featured ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg shadow-blue-500/25' : 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white hover:bg-gray-200' }}">Pilih {{ $package->name }}</button>
        </form>
    </div>
    @endforeach
</div>
@endsection
