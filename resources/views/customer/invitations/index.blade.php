@extends('layouts.dashboard')
@section('page-title', 'Undangan Saya')
@section('sidebar-nav')
<x-customer-nav />
@endsection

@section('content')
@php
    $user = auth()->user();

    $hasActiveSubscription = $user->activeSubscription() !== null;
    $totalInvitations = $user->invitations()->count();

    $canCreateInvitation = $hasActiveSubscription || $totalInvitations < 1;
@endphp

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Undangan Saya</h2>
        <p class="text-sm text-gray-500">Kelola semua undangan digital Anda</p>
    </div>

    @if($canCreateInvitation)
        <a href="{{ route('customer.invitations.create') }}"
            class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/25 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Undangan
        </a>
    @else
        <button type="button"
            onclick="alert('Paket gratis hanya bisa membuat 1 undangan. Upgrade paket untuk membuat lebih banyak.')"
            class="flex items-center gap-2 px-5 py-2.5 bg-gray-300 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-sm font-semibold rounded-xl cursor-not-allowed">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Undangan
        </button>
    @endif
</div>

@if(session('error'))
    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 rounded-2xl">
        <span class="text-sm">{{ session('error') }}</span>
    </div>
@endif

@if($invitations->isEmpty())
<div class="bg-white dark:bg-gray-800 rounded-2xl border p-16 text-center">
    <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
    </div>

    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Belum ada undangan</h3>
    <p class="text-gray-500 mb-6">Mulai buat undangan digital pertama Anda sekarang</p>

    @if($canCreateInvitation)
        <a href="{{ route('customer.invitations.create') }}"
            class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition">
            Buat Undangan Pertama
        </a>
    @endif
</div>
@else
<div class="grid gap-4">
    @foreach($invitations as $invitation)
        @php
            $isFreeInvitation = !$hasActiveSubscription && $invitation->package_id === null;

            $isExpiredFree =
                $isFreeInvitation &&
                $invitation->created_at &&
                $invitation->created_at->lt(now()->subDays(7));

            $expiredDate = $invitation->created_at?->copy()->addDays(7);
        @endphp

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 mb-2">
                        <h3 class="font-semibold text-gray-900 dark:text-white truncate">
                            {{ $invitation->title }}
                        </h3>

                        @if($isExpiredFree)
                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-red-100 text-red-700">
                                Expired
                            </span>
                        @else
                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full
                                {{ $invitation->status === 'published'
                                    ? 'bg-green-100 text-green-700'
                                    : ($invitation->status === 'paused'
                                        ? 'bg-yellow-100 text-yellow-700'
                                        : 'bg-gray-100 text-gray-700') }}">
                                {{ ucfirst($invitation->status) }}
                            </span>
                        @endif
                    </div>

                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                        <span>{{ $invitation->event_date->format('d M Y') }}</span>
                        <span>{{ $invitation->view_count }} views</span>

                        @if($invitation->template)
                            <span>{{ $invitation->template->name }}</span>
                        @endif
                    </div>

                    @if($isExpiredFree)
                        <div class="mt-3 text-sm text-red-600 font-medium">
                            Expired sejak {{ $expiredDate?->format('d M Y') }}
                        </div>
                    @elseif($isFreeInvitation)
                        <div class="mt-3 text-sm text-orange-600 font-medium">
                            Gratis sampai {{ $expiredDate?->format('d M Y') }}
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-2">
                    @if($invitation->isPublished() && !$isExpiredFree)
                        <a href="{{ $invitation->getUrl() }}" target="_blank"
                            class="p-2 text-gray-400 hover:text-blue-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    @endif

                    <a href="{{ route('customer.invitations.edit', $invitation) }}"
                        class="p-2 text-gray-400 hover:text-blue-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>

                    <form method="POST" action="{{ route('customer.invitations.destroy', $invitation) }}"
                        onsubmit="return confirm('Hapus undangan ini?')">
                        @csrf
                        @method('DELETE')

                        <button class="p-2 text-gray-400 hover:text-red-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="mt-6">
    {{ $invitations->links() }}
</div>
@endif
@endsection